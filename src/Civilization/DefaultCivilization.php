<?php
declare(strict_types=1);

namespace TileLand\Civilization;

use TileLand\Entity\Building;
use TileLand\Entity\Unit;

abstract class DefaultCivilization implements Civilization
{
    public function createBuildingEntity(\TileLand\City\Building\Building $building): Building
    {
        return $building->createEntity();
    }

    public function createUnitEntity(\TileLand\Unit\Unit $unit): Unit
    {
        return $unit->createEntity();
    }
}
