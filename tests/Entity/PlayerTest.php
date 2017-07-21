<?php

namespace TileLand\Tests\Entity;

use PHPUnit\Framework\TestCase;
use TileLand\Entity\City;
use TileLand\Entity\Player;
use TileLand\Entity\Unit;
use TileLand\Entity\UnitAttributes;
use TileLand\Enum\Civilization;
use TileLand\Enum\UnitType;
use TileLand\Unit\UnitFactory;

class PlayerTest extends TestCase
{
    public function testGetCivilization(): void
    {
        static::assertTrue(
            (new Player(Civilization::CHINESE(), true))
                ->getCivilization()
                ->equals(Civilization::CHINESE())
        );
    }

    public function testGetUnits(): void
    {
        $player = new Player(Civilization::CHINESE(), true);
        $player->addUnit(UnitFactory::createWithUnitType(UnitType::TRADER()));
        $player->addUnit(UnitFactory::createWithUnitType(UnitType::TRADER()));
        $player->addUnit(UnitFactory::createWithUnitType(UnitType::TRADER()));
        static::assertCount(3, $player->getUnits());
    }

    public function testGetCities(): void
    {
        $player = new Player(Civilization::CHINESE(), true);
        $player->addCity(new City('test'));
        $player->addCity(new City('test'));
        $player->addCity(new City('test'));
        static::assertCount(3, $player->getCities());
    }
}
