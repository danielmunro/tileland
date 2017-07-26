<?php

namespace TileLand\Tests\Entity;

use PHPUnit\Framework\TestCase;
use TileLand\City\Building\Barracks;
use TileLand\City\Building\Shrine;
use TileLand\City\Building\TradingPost;
use TileLand\City\StubProducible;
use TileLand\Civilization\TestCivilization;
use TileLand\Entity\Building;
use TileLand\Entity\City;
use TileLand\Entity\Production;
use TileLand\Entity\Tile;
use TileLand\Entity\Unit;
use TileLand\Entity\UnitAttributes;
use TileLand\Enum\ActionStatus;
use TileLand\Enum\Terrain;
use TileLand\Enum\UnitType;
use TileLand\Player\Action\CityAction;
use TileLand\Player\ActionContext\ProducibleActionContext;
use TileLand\Unit\Trader;

class CityTest extends TestCase
{
    /**
     * @var City
     */
    protected $city;

    public function setUp()
    {
        $this->city = new City('test');
    }

    public function testPopulationChange(): void
    {
        $population = $this->city->getPopulation();
        $this->city->increasePopulation();
        static::assertEquals($population + 1, $this->city->getPopulation());
        $this->city->decreasePopulation();
        static::assertEquals($population, $this->city->getPopulation());
    }

    /**
     * @covers \TileLand\Entity\City::addBuildingProduced
     */
    public function testAddProducedBuilding(): void
    {
        $civilization = new TestCivilization();
        $building = $civilization->createBuildingEntity(new TradingPost());
        static::assertFalse($this->city->hasBuilding($building));
        $this->city->addBuildingProduced($building);
        static::assertTrue($this->city->hasBuilding($building));
    }

    public function testProductionCompleted(): void
    {
        $trader = new Trader();
        $civilization = new TestCivilization();
        $tile = new Tile(Terrain::PLAINS());
        $this->city->changeProduction(new Production($civilization->createUnitEntity($trader)));
        $tile->setCity($this->city);
        $this->city->completeProduction();
        static::assertCount(1, $tile->getUnits());
        static::assertEquals($tile->getUnits()->first()->getUnitType(), $trader);
        static::assertNull($this->city->getProduction());
    }

    public function testAddUnlockedBuilding(): void
    {
        $civilization = new TestCivilization();
        $building = $civilization->createBuildingEntity(new TradingPost());
        static::assertFalse($this->city->hasBuilding($building));
        $this->city->addBuildingUnlocked($building);
        static::assertFalse($this->city->hasBuilding($building));
        static::assertTrue($this->city->canProduceBuilding($building));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCannotCompleteProductionOnNothing(): void
    {
        $this->city->completeProduction();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCannotAddUnlockedBuildingTwice(): void
    {
        $civilization = new TestCivilization();
        $tradingPost = new TradingPost();
        $this->city->addBuildingUnlocked($civilization->createBuildingEntity($tradingPost));
        $this->city->addBuildingUnlocked($civilization->createBuildingEntity($tradingPost));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCannotAddTwoBuildingsSameType(): void
    {
        $civilization = new TestCivilization();
        $tradingPost = new TradingPost();
        $this->city->addBuildingProduced($civilization->createBuildingEntity($tradingPost));
        $this->city->addBuildingProduced($civilization->createBuildingEntity($tradingPost));
    }

    public function testChangePersistProduction(): void
    {
        global $em;
        $civilization = new TestCivilization();
        $this->city->changeProduction(new Production($civilization->createBuildingEntity(new Shrine())));
        $em->persist($this->city);
        $em->flush();
        $this->city->changeProduction(new Production($civilization->createBuildingEntity(new Barracks())));
        $em->persist($this->city);
        $em->flush();
        static::assertEquals($this->city->getProduction()->getProducing()->getBuilding(), new Barracks());
    }

    public function testReduceProductionCost(): void
    {
        $civilization = new TestCivilization();
        $this->city->changeProduction(new Production($civilization->createBuildingEntity(new TradingPost())));
        $this->city->reduceProductionCost();
        static::assertLessThan((new TradingPost())->getBaseProductionCost(), $this->city->getRemainingProductionCost());
    }

    public function testCityStubProducible(): void
    {
        $action = $this->getMockBuilder(CityAction::class)
            ->disableOriginalConstructor()
            ->getMock();
        static::assertTrue(
            $this->city->performAction($action, new ProducibleActionContext(new StubProducible()))
                ->getActionStatus()
                ->equals(ActionStatus::COMPLETE())
        );
    }
}