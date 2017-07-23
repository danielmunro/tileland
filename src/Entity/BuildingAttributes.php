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
    protected $cultureProduction;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $faithProduction;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $scienceProduction;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $defense;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $maintenanceCostInGold;

    public function __construct(
        int $foodProduction,
        int $buildingProduction,
        int $unitProduction,
        int $goldProduction,
        int $faithProduction,
        int $cultureProduction,
        int $scienceProduction,
        int $defense,
        int $maintenanceCost
    ) {
        $this->foodProduction = $foodProduction;
        $this->buildingProduction = $buildingProduction;
        $this->unitProduction = $unitProduction;
        $this->goldProduction = $goldProduction;
        $this->faithProduction = $faithProduction;
        $this->cultureProduction = $cultureProduction;
        $this->scienceProduction = $scienceProduction;
        $this->defense = $defense;
        $this->maintenanceCostInGold = $maintenanceCost;
    }
}
