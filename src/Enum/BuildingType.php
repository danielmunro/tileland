<?php
declare(strict_types=1);

namespace TileLand\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static BuildingType GRANARY()
 * @method static BuildingType TRADING_POST()
 * @method static BuildingType BARRACKS()
 * @method static BuildingType SHRINE()
 */
class BuildingType extends Enum
{
    const GRANARY = 'granary';

    const TRADING_POST = 'trading post';

    const BARRACKS = 'barracks';

    const SHRINE = 'shrine';
}