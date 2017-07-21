<?php
declare(strict_types=1);

namespace TileLand\City;

use TileLand\Entity\City;

interface Producible
{
    public function getBaseProductionCost(): int;

    public function completed(City $city): void;
}
