<?php

namespace TileLand\Tests\Entity;

use PHPUnit\Framework\TestCase;
use TileLand\City\Building\Shrine;
use TileLand\City\Building\TradingPost;
use TileLand\Civilization\Civilization;
use TileLand\Civilization\TestCivilization;
use TileLand\Entity\City;
use TileLand\Entity\Player;
use TileLand\Unit\Trader;

class PlayerTest extends TestCase
{
    public function testDebitMaintenanceGold(): void
    {
        $civ = new TestCivilization();
        $city = new City('test');

        $building = $civ->createBuildingEntity(new TradingPost());
        $city->addBuildingProduced($building);
        $cost = $city->getMaintenanceCostInGold();
        static::assertGreaterThan(0, $cost);

        $building = $civ->createBuildingEntity(new Shrine());
        $city->addBuildingProduced($building);
        static::assertGreaterThan($cost, $city->getMaintenanceCostInGold());
    }

    /**
     * @dataProvider getNewUserCanCreateAnyCivilizationDatProvider
     * @param Civilization $civilization
     */
    public function testNewUserCanCreateAnyCivilization(Civilization $civilization): void
    {
        static::assertEquals(
            (new Player($civilization, false))->getCivilization(),
            $civilization
        );
    }

    public function getNewUserCanCreateAnyCivilizationDatProvider(): array
    {
        return [
            [
                new TestCivilization(),
            ],
        ];
    }

    public function testGetCivilization(): void
    {
        $civilization = new TestCivilization();
        static::assertEquals(
            $civilization,
            (new Player(new TestCivilization(), true))
                ->getCivilization()
        );
    }

    public function testGetUnits(): void
    {
        $civilization = new TestCivilization();
        $player = new Player($civilization, true);
        $player->addUnit($civilization->createUnitEntity(new Trader()));
        $player->addUnit($civilization->createUnitEntity(new Trader()));
        $player->addUnit($civilization->createUnitEntity(new Trader()));
        static::assertCount(3, $player->getUnits());
    }

    public function testGetCities(): void
    {
        $player = new Player(new TestCivilization(), true);
        $player->addCity(new City('test'));
        $player->addCity(new City('test'));
        $player->addCity(new City('test'));
        static::assertCount(3, $player->getCities());
    }
}
