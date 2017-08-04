<?php
declare(strict_types=1);

namespace TileLand\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use function Functional\reduce_left;
use TileLand\Enum\ActionStatus;
use TileLand\Player\Action\Action;
use TileLand\Player\Action\ActionCreator;
use TileLand\Player\Action\ActionResult;
use TileLand\Player\ActionContext\ActionContext;

/**
 * @Entity
 */
class City implements ActionCreator
{
    use PrimaryKeyTrait;

    /**
     * @var Player
     * @ManyToOne(targetEntity="Player", inversedBy="cities")
     */
    protected $owner;

    /**
     * @var Tile
     * @OneToOne(targetEntity="Tile", mappedBy="city")
     */
    protected $tile;

    /**
     * @var Collection
     * @OneToMany(targetEntity="Building", mappedBy="cityProduced")
     */
    protected $buildingsProduced;

    /**
     * @var Collection
     * @OneToMany(targetEntity="Building", mappedBy="cityUnlocked")
     */
    protected $buildingsUnlocked;

    /**
     * @var Production
     * @OneToOne(targetEntity="Production", orphanRemoval=true, cascade={"all"})
     */
    protected $production;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $population;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $name;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->buildingsProduced = new ArrayCollection();
        $this->buildingsUnlocked = new ArrayCollection();
        $this->population = 1;
    }

    public function getProductionCapacity(): int
    {
        return (int) floor($this->population * 1.5);
    }

    public function addBuildingUnlocked(Building $buildingEntity): void
    {
        if ($this->canProduceBuilding($buildingEntity)) {
            throw new \RuntimeException('City already has one of this building type!');
        }
        $this->buildingsUnlocked->add($buildingEntity);
        $buildingEntity->setCityUnlocked($this);
    }

    public function addBuildingProduced(Building $buildingEntity): void
    {
        if ($this->hasBuilding($buildingEntity)) {
            throw new \RuntimeException('City already has one of this building type!');
        }
        $this->buildingsProduced->add($buildingEntity);
        $buildingEntity->setCityProduced($this);
    }

    public function hasBuilding(Building $building): bool
    {
        return !$this->buildingsProduced->filter(function ($b) use ($building) {
            return $building->satisfies($b);
        })->isEmpty();
    }

    public function canProduceBuilding(Building $building): bool
    {
        return !$this->buildingsUnlocked->filter(function ($b) use ($building) {
            return $building->satisfies($b);
        })->isEmpty();
    }

    public function changeProduction(Production $production): void
    {
        $this->production = $production;
    }

    public function getProduction(): ?Production
    {
        return $this->production;
    }

    public function reduceProductionCost(): int
    {
        return $this->production->reduceCost();
    }

    public function getRemainingProductionCost(): int
    {
        return $this->production ? $this->production->getCost() : 0;
    }

    public function completeProduction(): void
    {
        if (!$this->production) {
            throw new \RuntimeException('City cannot complete production -- not producing anything');
        }

        $this->production->getProducing()->completed($this);
        $this->resetProduction();
    }

    public function resetProduction(): void
    {
        $this->production = null;
    }

    public function getMaintenanceCostInGold(): int
    {
        return reduce_left(
            $this->buildingsProduced->toArray(),
            function (Building $building, int $index, array $buildingsProduced, int $initial) {
                return $initial + $building->getMaintenanceCostInGold();
            },
            0
        );
    }

    public function addCompletedUnitToTile(Unit $unit): void
    {
        $this->tile->addUnit($unit);
    }

    public function setTile(Tile $tile): void
    {
        $this->tile = $tile;
    }

    public function performAction(Action $action, ActionContext $actionContext): ActionResult
    {
        switch (get_class($actionContext->getContext())) {
            case Building::class:
                $this->buildingsProduced->add($actionContext->getContext());
                break;
            case Unit::class:
                $this->tile->addUnit($actionContext->getContext());
                break;
            default:
                break;
        }

        return new ActionResult($this, ActionStatus::COMPLETE());
    }

    public function increasePopulation(): void
    {
        $this->population++;
    }

    public function decreasePopulation(): void
    {
        $this->population--;
    }

    public function getPopulation(): int
    {
        return $this->population;
    }
}
