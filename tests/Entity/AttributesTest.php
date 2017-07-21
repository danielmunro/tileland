<?php

namespace TileLand\Tests\Entity;

use PHPUnit\Framework\TestCase;
use TileLand\Entity\UnitAttributes;

class AttributesTest extends TestCase
{
    /**
     * @dataProvider getTestDamageRoll
     * @param string $dice
     * @param int $min
     * @param int $max
     */
    public function testDamageAndHitRoll(string $dice, int $min, int $max): void
    {
        $attributes = new UnitAttributes(1 , 1, 1, 0, $dice);
        for ($i = 0; $i < 50; $i++) {
            $roll = $attributes->getDamageRoll();
            static::assertTrue($roll >= $min);
            static::assertTrue($roll <= $max);
        }
    }

    public function getTestDamageRoll(): array
    {
        return [
            [
                '2d6',
                2,
                12,
            ],
            [
                'd4',
                1,
                4
            ],
            [
                'd100',
                1,
                100,
            ],
            [
                'df',
                -1,
                1,
            ],
            [
                '3d20',
                3,
                60,
            ],
        ];
    }

    public function testRegenAttributes(): void
    {
        $startingHp = 10;
        $damage = 2;
        $expectedHp = $startingHp - $damage;
        $startingMv = 1;
        $expectedMv = 0;
        $attributes = new UnitAttributes($startingHp, $startingMv, 1, 0, 'd6');
        $attributes->receiveDamage($damage);
        $attributes->consumeMovement();

        static::assertEquals($expectedHp, $attributes->getHp());
        static::assertEquals($expectedMv, $attributes->getMv());

        $attributes->regenHp();
        $attributes->regenMv();

        static::assertEquals($expectedHp + 1, $attributes->getHp());
        static::assertEquals($startingMv, $attributes->getMv());

        $attributes->regenHp();

        static::assertEquals($expectedHp + 2, $attributes->getHp());

        $attributes->regenHp();

        static::assertEquals($expectedHp + 2, $attributes->getHp());
        static::assertEquals($startingMv, $attributes->getMv());
        static::assertEquals($attributes->getHp(), $attributes->getMaxHp());
    }
}
