<?php
declare(strict_types=1);

namespace TileLand\Unit;

use TileLand\Entity\UnitAttributes;

class Forager implements Unit
{
    public function getName(): string
    {
        return Units::FORAGER;
    }

    public function getBaseProductionCost(): int
    {
        return 10;
    }

    public function createEntity(): \TileLand\Entity\Unit
    {
        return new \TileLand\Entity\Unit(
            $this,
            new UnitAttributes(
                10,
                2,
                0,
                0,
                '0'
            )
        );
    }
}
