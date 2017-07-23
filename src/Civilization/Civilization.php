<?php
declare(strict_types=1);

namespace TileLand\Civilization;

use TileLand\Entity\Building;
use TileLand\Entity\Unit;

interface Civilization
{
    public function createBuildingEntity(\TileLand\City\Building\Building $building): Building;

    public function createUnitEntity(\TileLand\Unit\Unit $unit): Unit;
}
