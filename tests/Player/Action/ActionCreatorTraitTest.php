<?php

namespace TileLand\Tests\Player\Action;

use PHPUnit\Framework\TestCase;
use TileLand\City\Building\TradingPost;
use TileLand\Entity\Building;
use TileLand\Entity\City;
use TileLand\Player\Action\CityAction;

class ActionCreatorTraitTest extends TestCase
{
    public function testGetActionCreator(): void
    {
        $city = new City('test');
        $cityAction = new CityAction($city, new Building(new TradingPost()));
        static::assertEquals($city, $cityAction->getActionCreator());
    }
}
