<?php

namespace TileLand\Tests\Entity;

use PHPUnit\Framework\TestCase;
use TileLand\City\Building\BuildingFactory;
use TileLand\City\Building\Buildings;
use TileLand\City\Building\Granary;
use TileLand\City\Building\Outpost;
use TileLand\City\Building\Shrine;
use TileLand\City\Building\TradingPost;
use TileLand\Entity\Building;
use TileLand\Entity\BuildingAttributes;
use TileLand\Entity\City;
use TileLand\Entity\Production;
use TileLand\Enum\BuildingType;

class BuildingTest extends TestCase
{
    public function testGetBuildingTypeEqualsExpectedBuildingType(): void
    {
        static::assertEquals((new Building(new Granary()))->getBuilding(), new Granary());
    }

    public function testBuildingCompleted(): void
    {
        $city = new City('test');
        $building = new Building(new TradingPost(), new BuildingAttributes());
        $city->changeProduction(new Production($building));
        $city->completeProduction();
        static::assertNull($city->getProduction());
        static::assertTrue($city->hasBuilding($building));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCannotMoveBuildingToDifferentCity(): void
    {
        $building = new Building(new Shrine());
        $building->setCityProduced(new City('test'));
        $building->setCityProduced(new City('test'));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCannotMoveUnlockedBuildingToDifferentCity(): void
    {
        $building = new Building(new Shrine());
        $building->setCityUnlocked(new City('test'));
        $building->setCityUnlocked(new City('test'));
    }

    public function testGetBaseProductionCost(): void
    {
        static::assertEquals(
            (new Shrine())->getBaseProductionCost(),
            (new Building(new Shrine()))->getBaseProductionCost()
        );
    }

    /**
     * @dataProvider getTestGetBuildingsUnlockedDataProvider
     *
     * @param \TileLand\City\Building\Building $building
     */
    public function testGetBuildingsUnlocked(\TileLand\City\Building\Building $building): void
    {
        $buildingEntity = new Building($building);
        foreach ($buildingEntity->getBuildingsUnlocked() as $buildingUnlocked) {
            static::assertInstanceOf(\TileLand\City\Building\Building::class, $buildingUnlocked);
        }
    }

    public function getTestGetBuildingsUnlockedDataProvider(): array
    {
        return [
            [
                new Granary(),
                new Outpost(),
            ],
        ];
    }
}