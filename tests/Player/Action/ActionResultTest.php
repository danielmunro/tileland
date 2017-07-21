<?php

namespace TileLand\Tests\Tile;

use PHPUnit\Framework\TestCase;
use TileLand\Entity\City;
use TileLand\Entity\Unit;
use TileLand\Entity\UnitAttributes;
use TileLand\Enum\ActionStatus;
use TileLand\Enum\UnitType;
use TileLand\Player\Action\ActionResult;

class ActionResultTest extends TestCase
{
    public function testGetActionCreator(): void
    {
        $city = new City('test');
        static::assertEquals($city, (new ActionResult($city, ActionStatus::COMPLETE()))->getActionCreator());

        $unit = new Unit(UnitType::TRADER(), new UnitAttributes(1, 1, 1, 0, '0'));
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
