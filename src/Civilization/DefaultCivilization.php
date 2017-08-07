<?php
declare(strict_types=1);

namespace TileLand\Civilization;

use function Functional\map;
use function Functional\reduce_left;
use TileLand\City\Building\Bonus\BuildingBonus;
use TileLand\Entity\Building;
use TileLand\Entity\Unit;

abstract class DefaultCivilization
{
    protected $buildingBonuses = [];

    public function createBuildingEntity(\TileLand\City\Building\Building $building): Building
    {
        return reduce_left(
            $this->buildingBonuses,
            function (BuildingBonus $bonus, int $index, array $bonuses, Building $building) {
                return $bonus->applyBonus($building);
            },
            $building->createEntity()
        );
    }

    public function createUnitEntity(\TileLand\Unit\Unit $unit): Unit
    {
        return $unit->createEntity();
    }

    protected function setBuildingBonuses(array $buildingBonuses): void
    {
        $this->buildingBonuses = $buildingBonuses;
    }
}
