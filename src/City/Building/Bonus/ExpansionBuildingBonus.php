<?php
declare(strict_types=1);

namespace TileLand\City\Building\Bonus;

use TileLand\Entity\Building;
use TileLand\Entity\BuildingAttributes;

class ExpansionBuildingBonus implements BuildingBonus
{
    public function applyBonus(Building $building): Building
    {
        return new Building(
            $building->getBuilding(),
            BuildingAttributes::createFromBuildingAttributes(
                $building->getBuildingAttributes(),
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                reductionModifier($building->getMaintenanceCostInGold())
            )
        );
    }
}
