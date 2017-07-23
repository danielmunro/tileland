<?php
declare(strict_types=1);

namespace TileLand\City\Building;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use TileLand\Civilization\Civilization;
use TileLand\Entity\BuildingAttributes;

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

    public function createEntityForCivilization(Civilization $civilization): \TileLand\Entity\Building
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
                0,
                0,
                0
            )
        );
    }
}
