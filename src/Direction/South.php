<?php
declare(strict_types=1);

namespace TileLand\Direction;

class South implements Direction
{
    public function getName(): string
    {
        return Directions::SOUTH;
    }

    public function getReverse(): Direction
    {
        return new North();
    }
}
