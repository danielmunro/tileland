<?php
declare(strict_types=1);

namespace TileLand\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static UnitType SETTLER()
 * @method static UnitType WORKER()
 * @method static UnitType FORAGER()
 * @method static UnitType CLUBMAN()
 * @method static UnitType SLINGER()
 * @method static UnitType EXPLORER()
 * @method static UnitType PAGAN()
 * @method static UnitType TRADER()
 */
class UnitType extends Enum
{
    const SETTLER = 'settler';

    const WORKER = 'worker';

    const CLUBMAN = 'clubman';

    const SLINGER = 'slinger';

    const EXPLORER = 'explorer';

    const FORAGER = 'forager';

    const PAGAN = 'pagan';

    const TRADER = 'trader';
}
