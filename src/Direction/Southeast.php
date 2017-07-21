<?php
declare(strict_types=1);

namespace TileLand\Direction;

class Southeast implements Direction
{
    public function getName(): string
    {
        return Directions::SOUTHEAST;
    }

    public function getReverse(): Direction
    {
        return new Northwest();
    }
}
