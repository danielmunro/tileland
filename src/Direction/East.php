<?php
declare(strict_types=1);

namespace TileLand\Direction;

class East implements Direction
{
    public function getName(): string
    {
        return Directions::EAST;
    }

    public function getReverse(): Direction
    {
        return new West();
    }
}
