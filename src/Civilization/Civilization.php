<?php
declare(strict_types=1);

namespace TileLand\Civilization;

use TileLand\Entity\Building;
use TileLand\Entity\Unit;
use TileLand\Enum\UnitType;

interface Civilization
{
    public function createBuildingEntity(\TileLand\City\Building\Building $building): Building;

    public function createUnitFromUnitType(UnitType $unitType): Unit;
}
