<?php
declare(strict_types=1);

namespace TileLand\Civilization;

use TileLand\City\Building\Bonus\ExpansionBuildingBonus;
use TileLand\City\Building\Bonus\MilitaryBuildingBonus;

class AlexanderTheGreat extends DefaultCivilization implements Civilization
{
    protected function __construct()
    {
        $this->setBuildingBonuses([
            new MilitaryBuildingBonus(),
            new ExpansionBuildingBonus(),
        ]);
    }

    public function getName(): string
    {
        return Civilizations::ALEXANDER_THE_GREAT;
    }
}
