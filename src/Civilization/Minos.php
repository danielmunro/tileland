<?php
declare(strict_types=1);

namespace TileLand\Civilization;

use TileLand\City\Building\Bonus\BuildingBuildingBonus;
use TileLand\City\Building\Bonus\CultureBuildingBonus;
use TileLand\City\Building\Bonus\EconomyBuildingBonus;

class Minos extends DefaultCivilization implements Civilization
{
    protected function __construct()
    {
        $this->setBuildingBonuses([
            new CultureBuildingBonus(),
            new BuildingBuildingBonus(),
            new EconomyBuildingBonus(),
        ]);
    }

    public function getName(): string
    {
        return Civilizations::MINOS;
    }
}
