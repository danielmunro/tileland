<?php
declare(strict_types=1);

namespace TileLand\City\Building;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use TileLand\Civilization\Civilization;
use TileLand\Entity\BuildingAttributes;

class Library implements Building
{
    public function getName(): string
    {
        return Buildings::LIBRARY;
    }

    public function getBaseProductionCost(): int
    {
        return 30;
    }

    public function getMaintenanceCostInGold(): int
    {
        return 1;
    }

    public function getBuildingsUnlocked(): Collection
    {
        return new ArrayCollection([]);
    }

    public function getUnitsUnlocked(): Collection
    {
        return new ArrayCollection([]);
    }

    public function createEntity(): \TileLand\Entity\Building
    {
        return new \TileLand\Entity\Building(
            $this,
            new BuildingAttributes(
                0,
                0,
                0,
                0,
                0,
                0,
                1,
                0,
                1
            )
        );
    }
}
