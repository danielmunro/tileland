<?php
declare(strict_types=1);

namespace TileLand\Direction;

class West implements Direction
{
    public function getName(): string
    {
        return Directions::WEST;
    }

    public function getReverse(): Direction
    {
        return new East();
    }
}
