<?php

namespace TileLand\Tests\Player\Action;

use PHPUnit\Framework\TestCase;
use TileLand\City\Building\TradingPost;
use TileLand\Civilization\TestCivilization;
use TileLand\Entity\Building;
use TileLand\Entity\City;
use TileLand\Player\Action\CityAction;

class ActionCreatorTraitTest extends TestCase
{
    public function testGetActionCreator(): void
    {
        $civilization = new TestCivilization();
        $city = new City('test');
        $cityAction = new CityAction($city, $civilization->createBuildingEntity(new TradingPost()));
        static::assertEquals($city, $cityAction->getActionCreator());
    }
}
