<?php
declare(strict_types=1);

namespace TileLand\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static Improvement FARM()
 * @method static Improvement MINE()
 * @method static Improvement STABLE()
 * @method static Improvement FISHERY()
 */
class Improvement extends Enum
{
    const FARM = 'farm';
    const MINE = 'mine';
    const STABLE = 'stable';
    const FISHERY = 'fishery';
}
