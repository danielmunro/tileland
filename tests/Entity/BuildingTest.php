<?php

namespace TileLand\Tests\Entity;

use PHPUnit\Framework\TestCase;
use TileLand\City\Building\BuildingFactory;
use TileLand\City\Building\Buildings;
use TileLand\City\Building\Granary;
use TileLand\City\Building\Outpost;
use TileLand\City\Building\Shrine;
use TileLand\City\Building\TradingPost;
use TileLand\Civilization\TestCivilization;
use TileLand\Entity\Building;
use TileLand\Entity\BuildingAttributes;
use TileLand\Entity\City;
use TileLand\Entity\Production;
use TileLand\Enum\BuildingType;

class BuildingTest extends TestCase
{
    public function testGetBuildingSanity(): void
    {
        $testCivilization = new TestCivilization();
        static::assertEquals(
            $testCivilization->createBuildingEntity(new Granary())->getBuilding(),
            new Granary()
        );
    }

    public function testBuildingCompleted(): void
    {
        $testCivilization = new TestCivilization();
        $city = new City('test');
        $building = $testCivilization->createBuildingEntity(new TradingPost());
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
        $testCivilization = new TestCivilization();
        $building = $testCivilization->createBuildingEntity(new Shrine());
        $building->setCityProduced(new City('test'));
        $building->setCityProduced(new City('test'));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCannotMoveUnlockedBuildingToDifferentCity(): void
    {
        $testCivilization = new TestCivilization();
        $building = $testCivilization->createBuildingEntity(new TradingPost());
        $building->setCityUnlocked(new City('test'));
        $building->setCityUnlocked(new City('test'));
    }

    public function testGetBaseProductionCost(): void
    {
        $testCivilization = new TestCivilization();
        static::assertEquals(
            (new Shrine())->getBaseProductionCost(),
            $testCivilization->createBuildingEntity(new Shrine())->getBaseProductionCost()
        );
    }

    /**
     * @dataProvider getTestGetBuildingsUnlockedDataProvider
     *
     * @param \TileLand\City\Building\Building $building
     */
    public function testGetBuildingsUnlocked(\TileLand\City\Building\Building $building): void
    {
        $testCivilization = new TestCivilization();
        $buildingEntity = $testCivilization->createBuildingEntity($building);
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