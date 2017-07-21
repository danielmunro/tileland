<?php
declare(strict_types=1);

namespace TileLand\Direction;

class Northeast implements Direction
{
    public function getName(): string
    {
        return Directions::NORTHEAST;
    }

    public function getReverse(): Direction
    {
        return new Southwest();
    }
}
