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
        int $maintenanceCostInGold
    ) {
        $this->foodProduction = $foodProduction;
        $this->buildingProduction = $buildingProduction;
        $this->unitProduction = $unitProduction;
        $this->goldProduction = $goldProduction;
        $this->faithProduction = $faithProduction;
        $this->cultureProduction = $cultureProduction;
        $this->scienceProduction = $scienceProduction;
        $this->defense = $defense;
        $this->maintenanceCostInGold = $maintenanceCostInGold;
    }

    public function getMaintenanceCostInGold(): int
    {
        return $this->maintenanceCostInGold;
    }

    public function getFoodProduction(): int
    {
        return $this->foodProduction;
    }

    public function getBuildingProduction(): int
    {
        return $this->buildingProduction;
    }

    public function getUnitProduction(): int
    {
        return $this->unitProduction;
    }

    public function getGoldProduction(): int
    {
        return $this->goldProduction;
    }

    public function getFaithProduction(): int
    {
        return $this->faithProduction;
    }

    public function getCultureProduction(): int
    {
        return $this->cultureProduction;
    }

    public function getScienceProduction(): int
    {
        return $this->scienceProduction;
    }

    public function getDefense(): int
    {
        return $this->defense;
    }

    public static function createFromBuildingAttributes(
        BuildingAttributes $buildingAttributes,
        int $foodProduction,
        int $buildingProduction,
        int $unitProduction,
        int $goldProduction,
        int $faithProduction,
        int $cultureProduction,
        int $scienceProduction,
        int $defense,
        int $maintenanceCostInGold
    ) {
        return new self(
            $buildingAttributes->getFoodProduction() + $foodProduction,
            $buildingAttributes->getBuildingProduction() + $buildingProduction,
            $buildingAttributes->getUnitProduction() + $unitProduction,
            $buildingAttributes->getGoldProduction() + $goldProduction,
            $buildingAttributes->getFaithProduction() + $faithProduction,
            $buildingAttributes->getCultureProduction() + $cultureProduction,
            $buildingAttributes->getScienceProduction() + $scienceProduction,
            $buildingAttributes->getDefense() + $defense,
            $buildingAttributes->getMaintenanceCostInGold() + $maintenanceCostInGold
        );
    }
}
