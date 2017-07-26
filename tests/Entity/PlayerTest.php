<?php

namespace TileLand\Tests\Entity;

use PHPUnit\Framework\TestCase;
use TileLand\Civilization\TestCivilization;
use TileLand\Entity\City;
use TileLand\Entity\Player;
use TileLand\Entity\Unit;
use TileLand\Entity\UnitAttributes;
use TileLand\Enum\Civilization;
use TileLand\Enum\UnitType;
use TileLand\Unit\Trader;
use TileLand\Unit\UnitFactory;

class PlayerTest extends TestCase
{
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
