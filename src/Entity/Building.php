<?php
declare(strict_types=1);

namespace TileLand\Entity;

use Doctrine\Common\Collections\Collection;
use TileLand\City\Building\BuildingFactory;
use TileLand\Enum\BuildingType;
use TileLand\City\Producible;

/**
 * @Entity
 */
class Building implements Producible
{
    use PrimaryKeyTrait;

    /**
     * @var BuildingType
     * @ORM\Column(type="string")
     */
    protected $building;

    /**
     * @var BuildingAttributes
     * @ORM\OneToOne(targetEntity="BuildingAttributes")
     */
    protected $buildingAttributes;

    /**
     * @var City
     * @ManyToOne(targetEntity="City", inversedBy="buildingsProduced")
     */
    protected $cityProduced;
    /**
     * @var City
     * @ManyToOne(targetEntity="City", inversedBy="buildingsUnlocked")
     */
    protected $cityUnlocked;

    public function __construct(\TileLand\City\Building\Building $building, BuildingAttributes $buildingAttributes)
    {
        $this->building = $building->getName();
        $this->buildingAttributes = $buildingAttributes;
    }

    public function getCultureProduction(): int
    {
        return $this->buildingAttributes->getCultureProduction();
    }

    public function getUnitProduction(): int
    {
        return $this->buildingAttributes->getUnitProduction();
    }

    public function getGoldProduction(): int
    {
        return $this->buildingAttributes->getGoldProduction();
    }

    public function getFaithProduction(): int
    {
        return $this->buildingAttributes->getFaithProduction();
    }

    public function getMaintenanceCostInGold(): int
    {
        return $this->buildingAttributes->getMaintenanceCostInGold();
    }

    public function getBuildingProduction(): int
    {
        return $this->buildingAttributes->getBuildingProduction();
    }

    /**
     * @todo remove?
     * @return BuildingAttributes
     */
    public function getBuildingAttributes(): BuildingAttributes
    {
        return $this->buildingAttributes;
    }

    public function getBuilding(): \TileLand\City\Building\Building
    {
        return BuildingFactory::createBuildingFromName($this->building);
    }

    public function satisfies(Building $building): bool
    {
        return $this->getBuilding()->getName() === $building->getBuilding()->getName();
    }

    public function setCityProduced(City $cityProduced): void
    {
        if ($this->cityProduced) {
            throw new \RuntimeException('city already defined for building!');
        }

        $this->cityProduced = $cityProduced;
    }

    public function setCityUnlocked(City $cityUnlocked): void
    {
        if ($this->cityUnlocked) {
            throw new \RuntimeException('city already defined for building!');
        }

        $this->cityUnlocked = $cityUnlocked;
    }

    public function getBaseProductionCost(): int
    {
        return $this->getBuilding()->getBaseProductionCost();
    }

    public function getBuildingsUnlocked(): Collection
    {
        return $this->getBuilding()->getBuildingsUnlocked();
    }

    public function completed(City $city): void
    {
        $city->addBuildingProduced($this);
    }
}
