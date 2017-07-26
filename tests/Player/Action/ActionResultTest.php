<?php

namespace TileLand\Tests\Tile;

use PHPUnit\Framework\TestCase;
use TileLand\Civilization\TestCivilization;
use TileLand\Entity\City;
use TileLand\Enum\ActionStatus;
use TileLand\Player\Action\ActionResult;
use TileLand\Unit\Trader;

class ActionResultTest extends TestCase
{
    public function testGetActionCreator(): void
    {
        $city = new City('test');
        static::assertEquals($city, (new ActionResult($city, ActionStatus::COMPLETE()))->getActionCreator());

        $civilization = new TestCivilization();
        $unit = $civilization->createUnitEntity(new Trader());
        static::assertEquals($unit, (new ActionResult($unit, ActionStatus::COMPLETE()))->getActionCreator());
    }

    public function testActionResultStatus(): void
    {
        $actionCreator = $this->getMockBuilder(City::class)
            ->disableOriginalConstructor()
            ->getMock();
        $actionStatus = ActionStatus::COMPLETE();
        static::assertTrue(
            (new ActionResult($actionCreator, $actionStatus))->getActionStatus()->equals($actionStatus)
        );
    }
}
