<?php

namespace TileLand\Tests\Direction;

use PHPUnit\Framework\TestCase;
use TileLand\Direction\Direction;
use TileLand\Direction\Directions;
use TileLand\Direction\East;
use TileLand\Direction\North;
use TileLand\Direction\Northeast;
use TileLand\Direction\Northwest;
use TileLand\Direction\South;
use TileLand\Direction\Southeast;
use TileLand\Direction\Southwest;
use TileLand\Direction\West;

class DirectionsTest extends TestCase
{
    /**
     * @dataProvider getTestNameDataProvider
     * @param string $expectedDirectionName
     * @param Direction $direction
     */
    public function testName(string $expectedDirectionName, Direction $direction): void
    {
        static::assertEquals($expectedDirectionName, $direction->getName());
    }

    public function getTestNameDataProvider(): array
    {
        return [
            [
                Directions::EAST,
                new East(),
            ],
            [
                Directions::WEST,
                new West(),
            ],
            [
                Directions::SOUTHWEST,
                new Southwest(),
            ],
            [
                Directions::SOUTHEAST,
                new Southeast(),
            ],
            [
                Directions::NORTHWEST,
                new Northwest(),
            ],
            [
                Directions::NORTHEAST,
                new Northeast(),
            ],
            [
                Directions::NORTH,
                new North(),
            ],
        ];
    }

    /**
     * @dataProvider getTestReverseDataProvider
     * @param Direction $initialDirection
     * @param Direction $expectedDirection
     */
    public function testReverse(Direction $initialDirection, Direction $expectedDirection): void
    {
        static::assertEquals($expectedDirection->getName(), $initialDirection->getReverse()->getName());
    }

    public function getTestReverseDataProvider(): array
    {
        return [
            [
                new North(),
                new South(),
            ],
            [
                new Northeast(),
                new Southwest(),
            ],
            [
                new East(),
                new West(),
            ],
            [
                new Southeast(),
                new Northwest(),
            ],
            [
                new South(),
                new North(),
            ],
            [
                new Southwest(),
                new Northeast(),
            ],
            [
                new West(),
                new East(),
            ],
            [
                new Northwest(),
                new Southeast(),
            ],
        ];
    }
}
