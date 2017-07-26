<?php
declare(strict_types=1);

namespace TileLand\Unit;

use TileLand\Entity\UnitAttributes;

class Explorer implements Unit
{
    public function getName(): string
    {
        return Units::EXPLORER;
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
                3,
                1,
                0,
                '1d5'
            )
        );
    }
}
