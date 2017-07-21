<?php
declare(strict_types=1);

namespace TileLand\City\Building;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use TileLand\Enum\UnitType;

class Barracks implements Building
{
    public function getName(): string
    {
        return Buildings::BARRACKS;
    }

    public function getBaseProductionCost(): int
    {
        return 25;
    }

    public function getBuildingsUnlocked(): Collection
    {
        return new ArrayCollection([]);
    }

    public function getUnitsUnlocked(): Collection
    {
        return new ArrayCollection([
            UnitType::CLUBMAN(),
        ]);
    }
}
