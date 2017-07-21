<?php

namespace TileLand\Tests\Entity;

use PHPUnit\Framework\TestCase;
use TileLand\Direction\West;
use TileLand\Entity\Edge;
use TileLand\Entity\Player;
use TileLand\Entity\Tile;
use TileLand\Entity\Turn;
use TileLand\Enum\ActionType;
use TileLand\Enum\Civilization;
use TileLand\Enum\Terrain;
use TileLand\Enum\UnitType;
use TileLand\Player\Action\UnitAction;
use TileLand\Unit\UnitFactory;

class UnitTest extends TestCase
{
    public function testAttack(): void
    {
        $unit1 = UnitFactory::createWithUnitType(UnitType::CLUBMAN());
        $unit2 = UnitFactory::createWithUnitType(UnitType::CLUBMAN());

        $unit1Hp = $unit1->getHp();
        $attack = $unit2->attack($unit1);
        static::assertEquals($unit1Hp - $attack->getDamage(), $unit1->getHp());
        static::assertTrue($attack->isAttackedUnitAlive());

        $unit2Hp = $unit2->getHp();
        $attack = $unit1->attack($unit2);
        static::assertEquals($unit2Hp - $attack->getDamage(), $unit2->getHp());
        static::assertTrue($attack->isAttackedUnitAlive());
    }

    public function testMoveAction(): void
    {
        $unit = UnitFactory::createWithUnitType(UnitType::TRADER());
        $tile1 = new Tile(Terrain::PLAINS());
        $tile2 = new Tile(Terrain::PLAINS());
        $tile1->addEdge(new Edge(new West(), $tile1, $tile2));
        $tile1->addUnit($unit);

        static::assertCount(1, $tile1->getUnits());
        static::assertCount(0, $tile2->getUnits());
        static::assertEquals($tile1, $unit->getTile());

        $turn = new Turn(new Player(Civilization::CHINESE(), true));
        $turn->start();
        $turn->addAction(new UnitAction($unit, ActionType::MOVE(), new West()));
        $turn->end();

        static::assertCount(0, $tile1->getUnits());
        static::assertCount(1, $tile2->getUnits());
        static::assertEquals($tile2, $unit->getTile());
    }
}