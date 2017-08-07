<?php
declare(strict_types=1);

namespace TileLand\City\Building;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use TileLand\Entity\BuildingAttributes;

class Monument implements Building
{
    public function getName(): string
    {
        return Buildings::MONUMENT;
    }

    public function getBaseProductionCost(): int
    {
        return 45;
    }

    public function getBuildingsUnlocked(): Collection
    {
        return new ArrayCollection([
        ]);
    }

    public function getUnitsUnlocked(): Collection
    {
        return new ArrayCollection([
        ]);
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
                1,
                0,
                0,
                0,
                2
            )
        );
    }
}

