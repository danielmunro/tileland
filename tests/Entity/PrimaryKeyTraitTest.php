<?php

namespace TileLand\Tests\Entity;

use PHPUnit\Framework\TestCase;
use TileLand\City\Building\TradingPost;
use TileLand\Civilization\TestCivilization;
use TileLand\Entity\Building;

class PrimaryKeyTraitTest extends TestCase
{
    public function testGetId(): void
    {
        $civilization = new TestCivilization();
        $building = $civilization->createBuildingEntity(new TradingPost());
        static::assertNull($building->getId());

        global $em;
        $em->persist($building);
        $em->flush();
        static::assertGreaterThan(0, $building->getId());
    }
}
