<?php
declare(strict_types=1);

namespace TileLand\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static ActionStatus COMPLETE()
 * @method static ActionStatus INTERRUPTED()
 */
class ActionStatus extends Enum
{
    const COMPLETE = 'complete';

    const INTERRUPTED = 'interrupted';
}
