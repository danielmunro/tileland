<?php
declare(strict_types=1);

namespace TileLand\Civilization;

class TestCivilization extends DefaultCivilization
{
    public function getName(): string
    {
        return Civilizations::TEST;
    }
}
