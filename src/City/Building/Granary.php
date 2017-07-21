<?php
declare(strict_types=1);

namespace TileLand\City\Building;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use TileLand\Enum\UnitType;

class Granary implements Building
{
    public function getName(): string
    {
        return Buildings::GRANARY;
    }

    public function getBaseProductionCost(): int
    {
        return 10;
    }

    public function getBuildingsUnlocked(): Collection
    {
        return new ArrayCollection([
            new Aqueduct(),
        ]);
    }

    public function getUnitsUnlocked(): Collection
    {
        return new ArrayCollection([
            UnitType::WORKER(),
            UnitType::FORAGER()
        ]);
    }
}
