<?php
declare(strict_types=1);

namespace TileLand\Civilization;

use TileLand\City\Building\Barracks;
use TileLand\City\Building\Granary;
use TileLand\City\Building\Shrine;
use TileLand\City\Building\TradingPost;
use TileLand\Entity\Building;
use TileLand\Entity\BuildingAttributes;
use TileLand\Entity\Unit;
use TileLand\Enum\UnitType;

abstract class DefaultCivilization implements Civilization
{
    public function createBuildingEntity(\TileLand\City\Building\Building $building): Building
    {
        switch (get_class($building)) {
            case TradingPost::class:
                return new Building(
                    $building,
                    new BuildingAttributes(
                        0,
                        0,
                        0,
                        1,
                        0,
                        0,
                        0
                    )
                );
            case Granary::class:
                return new Building(
                    $building,
                    new BuildingAttributes(
                        1,
                        0,
                        0,
                        0,
                        0,
                        0,
                        1
                    )
                );
            case Shrine::class:
                return new Building(
                    $building,
                    new BuildingAttributes(
                        0,
                        0,
                        0,
                        0,
                        1,
                        0,
                        1
                    )
                );
            case Barracks::class:
                return new Building(
                    $building,
                    new BuildingAttributes(
                        0,
                        0,
                        1,
                        0,
                        0,
                        0,
                        1
                    )
                );
            default:
                throw new \InvalidArgumentException();
        }
    }

    public function createUnitFromUnitType(UnitType $unitType): Unit
    {
        switch (get_class($unitType)) {
            default:
                throw new \RuntimeException('not implemented');
        }
    }
}
