<?php
declare(strict_types=1);

namespace TileLand\Direction;

class North implements Direction
{
    public function getName(): string
    {
        return Directions::NORTH;
    }

    public function getReverse(): Direction
    {
        return new South();
    }
}
