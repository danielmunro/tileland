<?php
declare(strict_types=1);

namespace TileLand\Entity;

/**
 * @Entity
 */
class BuildingAttributes
{
    use PrimaryKeyTrait;

    /**
     * @var
     */
    protected $unitsUnlocked;

    /**
     * @var
     */
    protected $buildingsUnlocked;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $foodProduction;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $buildingProduction;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $unitProduction;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $goldProduction;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $maintenanceCostInGold;
}
