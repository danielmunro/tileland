<?php
declare(strict_types=1);

namespace TileLand\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static Terrain PLAINS()
 * @method static Terrain MOUNTAINS()
 * @method static Terrain HILLS()
 * @method static Terrain RIVER()
 * @method static Terrain DESERT()
 * @method static Terrain OCEAN()
 */
class Terrain extends Enum
{
    const PLAINS = 'plains';

    const MOUNTAINS = 'mountains';

    const HILLS = 'hills';

    const RIVER = 'river';

    const DESERT = 'desert';

    const OCEAN = 'ocean';
}
