<?php
declare(strict_types=1);

namespace TileLand\Direction;

interface Direction
{
    public function getName(): string;

    public function getReverse(): Direction;
}