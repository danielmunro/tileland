<?php
declare(strict_types=1);

namespace TileLand\Tests\Civilization;

use PHPUnit\Framework\TestCase;
use TileLand\City\Building\TestBuilding;
use TileLand\Civilization\TestCivilization;

class DefaultCivilizationTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateBuildingCivilizationCannotCreate(): void
    {
        (new TestCivilization())->createBuildingEntity(new TestBuilding());
    }
}
