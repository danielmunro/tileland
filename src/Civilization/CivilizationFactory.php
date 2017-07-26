<?php
declare(strict_types=1);

namespace TileLand\Civilization;

abstract class CivilizationFactory
{
    public static function createCivilizationFromName(string $name): Civilization
    {
        switch ($name) {
            case Civilizations::TEST:
                return new TestCivilization();
            default:
                throw new \InvalidArgumentException();
        }
    }
}
