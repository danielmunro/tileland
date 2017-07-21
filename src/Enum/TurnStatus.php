<?php
declare(strict_types=1);

namespace TileLand\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static TurnStatus INITIALIZED()
 * @method static TurnStatus IN_PLAY()
 * @method static TurnStatus ENDED()
 */
class TurnStatus extends Enum
{
    const INITIALIZED = 'initialized';

    const IN_PLAY = 'in play';

    const ENDED = 'ended';
}
