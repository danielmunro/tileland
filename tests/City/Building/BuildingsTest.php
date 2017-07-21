<?php

namespace TileLand\Tests\City\Building;

use PHPUnit\Framework\TestCase;
use TileLand\City\Building\Barracks;
use TileLand\City\Building\Building;
use TileLand\City\Building\Buildings;
use TileLand\City\Building\Granary;
use TileLand\City\Building\Outpost;
use TileLand\City\Building\Shrine;
use TileLand\City\Building\TradingPost;
use TileLand\Direction\Direction;
use TileLand\Direction\East;
use TileLand\Direction\North;
use TileLand\Direction\Northeast;
use TileLand\Direction\Northwest;
use TileLand\Direction\South;
use TileLand\Direction\Southeast;
use TileLand\Direction\Southwest;
use TileLand\Direction\West;

class BuildingsTest extends TestCase
{
    /**
     * @dataProvider getBuildingsDataProvider
     * @param string $expectedName
     * @param Building $building
     */
    public function testName(string $expectedName, Building $building): void
    {
        static::assertEquals($expectedName, $building->getName());
    }

    /**
     * @dataProvider getBuildingsDataProvider
     * @param string $expectedName
     * @param Building $building
     */
    public function testBaseProductionCostSanityCheck(string $expectedName, Building $building): void
    {
        static::assertGreaterThan(0, $building->getBaseProductionCost());
        static::assertLessThan(Building::MAX_BASE_PRODUCTION_COST, $building->getBaseProductionCost());
    }

    public function getBuildingsDataProvider(): array
    {
        return [
            [
                Buildings::OUTPOST,
                new Outpost(),
            ],
            [
                Buildings::TRADING_POST,
                new TradingPost(),
            ],
            [
                Buildings::BARRACKS,
                new Barracks(),
            ],
            [
                Buildings::SHRINE,
                new Shrine(),
            ],
            [
                Buildings::GRANARY,
                new Granary(),
            ],
        ];
    }
}
