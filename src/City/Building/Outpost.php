<?php
declare(strict_types=1);

namespace TileLand\City\Building;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use TileLand\Enum\UnitType;

class Outpost implements Building
{
    public function getName(): string
    {
        return Buildings::OUTPOST;
    }

    public function getBaseProductionCost(): int
    {
        return 15;
    }

    public function getBuildingsUnlocked(): Collection
    {
        return new ArrayCollection([
            new Walls(),
        ]);
    }

    public function getUnitsUnlocked(): Collection
    {
        return new ArrayCollection([
            UnitType::EXPLORER(),
        ]);
    }
}
