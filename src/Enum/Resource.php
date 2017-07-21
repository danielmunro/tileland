<?php
declare(strict_types=1);

namespace TileLand\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static Resource FOREST()
 * @method static Resource COTTON()
 * @method static Resource GOLD()
 * @method static Resource IRON()
 * @method static Resource HORSES()
 * @method static Resource SHEEP()
 * @method static Resource STONE()
 */
class Resource extends Enum
{
    const FOREST = 'forest';
    const COTTON = 'cotton';
    const GOLD = 'gold';
    const IRON = 'iron';
    const HORSES = 'horses';
    const SHEEP = 'sheep';
    const STONE = 'stone';
}
