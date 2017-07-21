<?php

namespace TileLand\Tests\Entity;

use PHPUnit\Framework\TestCase;
use TileLand\City\Building\TradingPost;
use TileLand\City\StubProducible;
use TileLand\Entity\Building;
use TileLand\Entity\Production;
use TileLand\Entity\UnitAttributes;
use TileLand\Entity\Unit;
use TileLand\Enum\UnitType;
use TileLand\Unit\UnitFactory;

class ProductionTest extends TestCase
{
    public function testSetUnitProduction(): void
    {
        $unit = UnitFactory::createWithUnitType(UnitType::CLUBMAN());
        $production = new Production($unit);
        static::assertEquals($unit, $production->getProducing());
    }

    public function testSetBuildingProduction(): void
    {
        $building = new Building(new TradingPost());
        $production = new Production($building);
        static::assertEquals($building, $production->getProducing());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testSetUnknownProducibleProduction(): void
    {
        $stubProducible = new StubProducible();
        new Production($stubProducible);
    }
}
