<?php
declare(strict_types=1);

namespace TileLand\City\Building;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class TestBuilding implements Building
{
    public function getName(): string
    {
        return Buildings::TEST_BUILDING;
    }

    public function getBaseProductionCost(): int
    {
        return 10;
    }

    public function getBuildingsUnlocked(): Collection
    {
        return new ArrayCollection([]);
    }

    public function getUnitsUnlocked(): Collection
    {
        return new ArrayCollection([]);
    }
}