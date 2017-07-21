<?php

namespace TileLand\Tests\Entity;

use PHPUnit\Framework\TestCase;
use TileLand\City\Building\Barracks;
use TileLand\City\Building\Shrine;
use TileLand\City\Building\TradingPost;
use TileLand\City\StubProducible;
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
        $building = new Building(new TradingPost());
        static::assertFalse($this->city->hasBuilding($building));
        $this->city->addBuildingProduced($building);
        static::assertTrue($this->city->hasBuilding($building));
    }

    public function testProductionCompleted(): void
    {
        $tile = new Tile(Terrain::PLAINS());
        $this->city->changeProduction(new Production(new Unit(UnitType::TRADER(), new UnitAttributes(1, 1, 1, 0, '0'))));
        $tile->setCity($this->city);
        $this->city->completeProduction();
        static::assertCount(1, $tile->getUnits());
        static::assertTrue($tile->getUnits()->first()->getUnitType()->equals(UnitType::TRADER()));
        static::assertNull($this->city->getProduction());
    }

    public function testAddUnlockedBuilding(): void
    {
        $building = new Building(new TradingPost());
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
        $tradingPost = new TradingPost();
        $this->city->addBuildingUnlocked(new Building($tradingPost));
        $this->city->addBuildingUnlocked(new Building($tradingPost));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCannotAddTwoBuildingsSameType(): void
    {
        $tradingPost = new TradingPost();
        $this->city->addBuildingProduced(new Building($tradingPost));
        $this->city->addBuildingProduced(new Building($tradingPost));
    }

    public function testChangePersistProduction(): void
    {
        global $em;
        $this->city->changeProduction(new Production(new Building(new Shrine())));
        $em->persist($this->city);
        $em->flush();
        $this->city->changeProduction(new Production(new Building(new Barracks())));
        $em->persist($this->city);
        $em->flush();
        static::assertEquals($this->city->getProduction()->getProducing()->getBuilding(), new Barracks());
    }

    public function testReduceProductionCost(): void
    {
        $this->city->changeProduction(new Production(new Building(new TradingPost())));
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