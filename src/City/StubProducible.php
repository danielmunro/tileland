<?php
declare(strict_types=1);

namespace TileLand\City;

use TileLand\Entity\City;

class StubProducible implements Producible
{
    public function getMaintenanceCostInGold(): int
    {
        return 10;
    }

    public function getBaseProductionCost(): int
    {
        return 10;
    }

    public function completed(City $city): void
    {
        $city->resetProduction();
    }
}
