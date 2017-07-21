<?php
declare(strict_types=1);

namespace TileLand\City\Building;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use TileLand\Enum\UnitType;

class Shrine implements Building
{
    public function getName(): string
    {
        return Buildings::SHRINE;
    }

    public function getBaseProductionCost(): int
    {
        return 20;
    }

    public function getBuildingsUnlocked(): Collection
    {
        return new ArrayCollection([]);
    }

    public function getUnitsUnlocked(): Collection
    {
        return new ArrayCollection([
            UnitType::PAGAN(),
        ]);
    }
}