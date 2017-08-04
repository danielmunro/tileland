<?php
declare(strict_types=1);

namespace TileLand\Entity;

use TileLand\City\Producible;

/**
 * @Entity
 */
class Production
{
    use PrimaryKeyTrait;

    /**
     * @var Building|null
     * @OneToOne(targetEntity="Building", cascade={"all"})
     */
    protected $building;

    /**
     * @var Unit|null
     * @OneToOne(targetEntity="Unit", cascade={"all"})
     */
    protected $unit;

    protected $wonder;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $cost;

    public function __construct(Producible $producible)
    {
        $this->setProduction($producible);
    }

    public function getProducing()
    {
        return $this->building ?? $this->unit;
    }

    public function reduceCost(): int
    {
        $this->cost--;

        return $this->cost;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    private function setProduction(Producible $producible): void
    {
        switch (get_class($producible)) {
            case Building::class:
                $this->building = $producible;
                $this->unit = null;
                break;
            case Unit::class:
                $this->building = null;
                $this->unit = $producible;
                break;
            default:
                throw new \RuntimeException('unknown producible type!');
        }

        $this->cost = $producible->getBaseProductionCost();
    }
}
