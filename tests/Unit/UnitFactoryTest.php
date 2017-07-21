<?php

namespace TileLand\Tests\Entity;

use PHPUnit\Framework\TestCase;
use TileLand\Entity\Unit;
use TileLand\Enum\UnitType;
use TileLand\Unit\UnitFactory;

class UnitFactoryTest extends TestCase
{
    /**
     * @dataProvider getTestCreateWithUnitTypeDataProvider
     * @param UnitType $unitType
     */
    public function testCreateWithUnitType(UnitType $unitType): void
    {
        $unit = UnitFactory::createWithUnitType($unitType);
        static::assertInstanceOf(Unit::class, $unit);
        static::assertTrue($unit->getUnitType()->equals($unitType));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCreateNonExistentUnitType(): void
    {
        $unitType = $this->getMockBuilder(UnitType::class)
            ->disableOriginalConstructor()
            ->getMock();
        $unitType->expects($this->any())
            ->method('getValue')
            ->willReturn('foo');
        UnitFactory::createWithUnitType($unitType);
    }

    public function getTestCreateWithUnitTypeDataProvider(): array
    {
        return [
            [
                UnitType::TRADER(),
            ],
            [
                UnitType::CLUBMAN(),
            ],
            [
                UnitType::EXPLORER(),
            ],
        ];
    }
}