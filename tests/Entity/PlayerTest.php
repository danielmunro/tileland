<?php

namespace TileLand\Tests\Entity;

use PHPUnit\Framework\TestCase;
use TileLand\City\Building\Shrine;
use TileLand\City\Building\TradingPost;
use TileLand\Civilization\Civilization;
use TileLand\Civilization\TestCivilization;
use TileLand\Entity\City;
use TileLand\Entity\Game;
use TileLand\Entity\Player;
use TileLand\Unit\Trader;

class PlayerTest extends TestCase
{
    /**
     * @dataProvider getNewUserCanCreateAnyCivilizationDatProvider
     * @param Civilization $civilization
     */
    public function testNewUserCanCreateAnyCivilization(Civilization $civilization): void
    {
        $player = new Player(
            $this->getMockBuilder(Game::class)->disableOriginalConstructor()->getMock(),
            $civilization,
            true
        );
        static::assertEquals(
            $player->getCivilization(),
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
        $player = new Player(
            $this->getMockBuilder(Game::class)->disableOriginalConstructor()->getMock(),
            new TestCivilization(),
            true
        );
        static::assertEquals($civilization, $player->getCivilization());
    }

    public function testGetUnits(): void
    {
        $civilization = new TestCivilization();
        $player = new Player(
            $this->getMockBuilder(Game::class)->disableOriginalConstructor()->getMock(),
            new TestCivilization(),
            true
        );
        $player->addUnit($civilization->createUnitEntity(new Trader()));
        $player->addUnit($civilization->createUnitEntity(new Trader()));
        $player->addUnit($civilization->createUnitEntity(new Trader()));
        static::assertCount(3, $player->getUnits());
    }

    public function testGetCities(): void
    {
        $player = new Player(
            $this->getMockBuilder(Game::class)->disableOriginalConstructor()->getMock(),
            new TestCivilization(),
            true
        );
        $player->addCity(new City('test'));
        $player->addCity(new City('test'));
        $player->addCity(new City('test'));
        static::assertCount(3, $player->getCities());
    }
}
