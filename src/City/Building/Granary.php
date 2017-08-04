<?php
declare(strict_types=1);

namespace TileLand\City\Building;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use TileLand\Entity\BuildingAttributes;
use TileLand\Unit\Forager;
use TileLand\Unit\Worker;

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

    public function getMaintenanceCostInGold(): int
    {
        return 1;
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
            new Worker(),
            new Forager(),
        ]);
    }

    public function createEntity(): \TileLand\Entity\Building
    {
        return new \TileLand\Entity\Building(
            $this,
            new BuildingAttributes(
                1,
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                1
            )
        );
    }
}
