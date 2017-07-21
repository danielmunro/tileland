<?php
declare(strict_types=1);

namespace TileLand\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static Civilization EGYPTIAN()
 * @method static Civilization INDUS()
 * @method static Civilization INCA()
 * @method static Civilization CHINESE()
 * @method static Civilization IROQUOIS()
 */
class Civilization extends Enum
{
    const EGYPTIAN = 'egyptian';

    const INDUS = 'indus';

    const INCA = 'inca';

    const CHINESE = 'chinese';

    const IROQUOIS = 'iroquois';
}
