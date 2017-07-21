<?php

namespace TileLand\Tests\Tile;

use PHPUnit\Framework\TestCase;
use TileLand\City\Building\BuildingFactory;
use TileLand\City\Building\Buildings;

class BuildingFactoryTest extends TestCase
{
    /**
     * @dataProvider getTestCreateBuildingFromNameDataProvider
     * @param string $name
     */
    public function testCreateBuildingFromName(string $name): void
    {
        static::assertEquals($name, BuildingFactory::createBuildingFromName($name)->getName());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testBadBuildingNameThrowsException(): void
    {
        BuildingFactory::createBuildingFromName('this is not a real building name');
    }

    public function getTestCreateBuildingFromNameDataProvider(): array
    {
        return [
            [
                Buildings::GRANARY,
            ],
            [
                Buildings::SHRINE,
            ],
            [
                Buildings::BARRACKS,
            ],
            [
                Buildings::TRADING_POST,
            ],
            [
                Buildings::OUTPOST,
            ],
        ];
    }
}
