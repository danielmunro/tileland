<?php
declare(strict_types=1);

namespace TileLand\Direction;

class Northwest implements Direction
{
    public function getName(): string
    {
        return Directions::NORTHWEST;
    }

    public function getReverse(): Direction
    {
        return new Southeast();
    }
}
