<?php
declare(strict_types=1);

namespace TileLand\Unit;

abstract class UnitFactory
{
    public static function createUnitFromName(string $name): Unit
    {
        switch ($name) {
            case Units::CLUBMAN:
                return new Clubman();
            case Units::EXPLORER:
                return new Explorer();
            case Units::TRADER:
                return new Trader();
            default:
                throw new \InvalidArgumentException();
        }
    }
}
