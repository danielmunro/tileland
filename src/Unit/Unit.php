<?php
declare(strict_types=1);

namespace TileLand\Unit;

interface Unit
{
    public function getName(): string;

    public function getBaseProductionCost(): int;

    public function createEntity(): \TileLand\Entity\Unit;

    //public function attack(Unit $unit)
}