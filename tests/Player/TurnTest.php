<?php

namespace TileLand\Tests\Tile;

use PHPUnit\Framework\TestCase;
use TileLand\City\Building\TradingPost;
use TileLand\Civilization\TestCivilization;
use TileLand\Entity\City;
use TileLand\Entity\Game;
use TileLand\Entity\Player;
use TileLand\Entity\Tile;
use TileLand\Enum\Terrain;
use TileLand\Player\Action\CityAction;
use TileLand\Player\Turn;
use TileLand\Unit\Trader;

class TurnTest extends TestCase
{
    /**
     * @var Turn
     */
    protected $turn;

    /**
     * @var Player
     */
    protected $player;

    public function setUp(): void
    {
        $this->player = new Player(
            $this->getMockBuilder(Game::class)->disableOriginalConstructor()->getMock(),
            $this->getMockBuilder(TestCivilization::class)->getMock(),
            true
        );
        $this->turn = new Turn($this->player);
    }

    public function testEndTurnIncrementPlayerTurnCount(): void
    {
        static::assertEquals(0, $this->player->getTurn());
        static::assertEquals(1, $this->turn->end());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCannotAddActionBeforeTurnStarts(): void
    {
        $civilization = new TestCivilization();
        $city = new City('test');
        $this->turn->addAction(new CityAction($city, $civilization->createBuildingEntity(new TradingPost())));
    }

    public function testAddActionBuildUnit(): void
    {
        $this->turn->start();
        $tile = new Tile(Terrain::PLAINS());
        $city = new City('test');
        $tile->setCity($city);
        $this->player->addCity($city);
        $civilization = new TestCivilization();
        $this->turn->addAction(new CityAction($city, $civilization->createUnitEntity(new Trader())));
        static::assertCount(0, $tile->getUnits());
        $this->turn->end();
        static::assertCount(1, $tile->getUnits());
    }

    public function testStartTurnReduceProduction(): void
    {
        $this->turn->start();
        $city = new City('test');
        $this->player->addCity($city);
        $civilization = new TestCivilization();
        $building = $civilization->createBuildingEntity(new TradingPost());
        $productionCost = $building->getBaseProductionCost();
        $this->turn->addAction(new CityAction($city, $building));
        $this->turn->start();
        $this->turn->end();
        static::assertLessThan($productionCost, $city->getRemainingProductionCost());
    }

    public function testStartRegenUnits(): void
    {
        $civilization = new TestCivilization();
        $unit = $civilization->createUnitEntity(new Trader());
        $startingHp = $unit->getHp();
        $unit->receiveDamage(5);
        $unit->consumeMovement();
        static::assertLessThan($unit->getMaxMv(), $unit->getMv());
        $this->player->addUnit($unit);
        $this->turn->start();
        static::assertGreaterThan($unit->getHp(), $startingHp);
        static::assertEquals($unit->getMv(), $unit->getMaxMv());

    }

    public function testCanOnlyQueueOneActionCreatorAtATime(): void
    {
        $this->turn->start();
        $city = new City('test');
        $tile = new Tile(Terrain::PLAINS());
        $tile->setCity($city);
        $this->player->addCity($city);
        $mockAction1 = $this->getMockBuilder(CityAction::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockAction1->expects($this->never())
            ->method('consume');
        $mockAction1->expects($this->any())
            ->method('getActionCreator')
            ->willReturn($city);
        $this->turn->addAction($mockAction1);
        $mockAction2 = $this->getMockBuilder(CityAction::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockAction2->expects($this->once())
            ->method('consume');
        $mockAction2->expects($this->any())
            ->method('getActionCreator')
            ->willReturn($city);
        $this->turn->addAction($mockAction2);
        $this->turn->end();
    }
}
