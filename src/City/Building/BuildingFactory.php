<?php
declare(strict_types=1);

namespace TileLand\City\Building;

class BuildingFactory
{
    public static function createBuildingFromName(string $name): Building
    {
        switch ($name) {
            case Buildings::GRANARY:
                return new Granary();
            case Buildings::TRADING_POST:
                return new TradingPost();
            case Buildings::SHRINE:
                return new Shrine();
            case Buildings::BARRACKS:
                return new Barracks();
            case Buildings::OUTPOST:
                return new Outpost();
            default:
                throw new \InvalidArgumentException(sprintf('building %s not found', $name));
        }
    }
}
