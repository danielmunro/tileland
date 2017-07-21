<?php
declare(strict_types=1);

namespace TileLand\Direction;

class Southwest implements Direction
{
    public function getName(): string
    {
        return Directions::SOUTHWEST;
    }

    public function getReverse(): Direction
    {
        return new Northeast();
    }
}
