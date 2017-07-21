<?php
declare(strict_types=1);

namespace TileLand\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static ActionType MOVE()
 * @method static ActionType ATTACK()
 * @method static ActionType FORTIFY()
 * @method static ActionType EXPLORE()
 * @method static ActionType IMPROVE()
 */
class ActionType extends Enum
{
    const MOVE = 'move';

    const ATTACK = 'attack';

    const FORTIFY = 'fortify';

    const EXPLORE = 'explore';

    const IMPROVE = 'improve';
}
