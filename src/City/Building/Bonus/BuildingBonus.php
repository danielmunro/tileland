<?php
declare(strict_types=1);

namespace TileLand\City\Building\Bonus;

use TileLand\Entity\Building;

interface BuildingBonus
{
    public function applyBonus(Building $building): Building;
}