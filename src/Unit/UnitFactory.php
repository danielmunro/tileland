<?php
declare(strict_types=1);

namespace TileLand\Unit;

use TileLand\Entity\Unit;
use TileLand\Entity\UnitAttributes;
use TileLand\Enum\UnitType;

class UnitFactory
{
    public static function createWithUnitType(UnitType $unitType): Unit
    {
        if ($unitType->equals(UnitType::TRADER())) {
            return self::create($unitType, 6, 3, 0, 0, '0');
        } else if ($unitType->equals(UnitType::CLUBMAN())) {
            return self::create($unitType, 10, 2, 1, 0, 'd4+2');
        } else if ($unitType->equals(UnitType::EXPLORER())) {
            return self::create($unitType, 8, 3, 1, 0, 'd3+1');
        }

        throw new \RuntimeException('unknown unit type');
    }

    protected static function create(UnitType $unitType, int $maxHp, int $maxMv, int $armorClass, int $range, string $damageDice): Unit
    {
        return new Unit(
            $unitType,
            new UnitAttributes($maxHp, $maxMv, $armorClass, $range, $damageDice)
        );
    }
}