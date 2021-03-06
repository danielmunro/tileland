<?php
declare(strict_types=1);

namespace TileLand\Civilization;

use TileLand\City\Building\Bonus\CultureBuildingBonus;
use TileLand\City\Building\Bonus\MilitaryBuildingBonus;

class RamessesII extends DefaultCivilization implements Civilization
{
    protected function __construct()
    {
        $this->setBuildingBonuses([
            new CultureBuildingBonus(),
            new MilitaryBuildingBonus(),
        ]);
    }

    public function getName(): string
    {
        return Civilizations::RAMESSES_II;
    }
}
