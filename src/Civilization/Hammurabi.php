<?php
declare(strict_types=1);

namespace TileLand\Civilization;

use TileLand\City\Building\Bonus\CultureBuildingBonus;
use TileLand\City\Building\Bonus\MilitaryBuildingBonus;
use TileLand\City\Building\Bonus\ReligionBuildingBonus;

class Hammurabi extends DefaultCivilization implements Civilization
{
    protected function __construct()
    {
        $this->setBuildingBonuses([
            new CultureBuildingBonus(),
            new MilitaryBuildingBonus(),
            new ReligionBuildingBonus(),
        ]);
    }

    public function getName(): string
    {
        return Civilizations::HAMMURABI;
    }
}
