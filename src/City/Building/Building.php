<?php
declare(strict_types=1);

namespace TileLand\City\Building;

use Doctrine\Common\Collections\Collection;
use TileLand\Civilization\Civilization;

interface Building
{
    const MAX_BASE_PRODUCTION_COST = 100;

    public function getName(): string;

    public function getBaseProductionCost(): int;

    public function getUnitsUnlocked(): Collection;

    public function getBuildingsUnlocked(): Collection;

    public function createEntityForCivilization(Civilization $civilization): \TileLand\Entity\Building;
}
