<?php
declare(strict_types=1);

namespace TileLand\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static Url GET_GAME_LIST()
 * @method static Url GET_GAME()
 * @method static Url POST_GAME()
 * @method static Url GET_PLAYER()
 * @method static Url POST_PLAYER()
 */
class Url extends Enum
{
    const GET_GAME_LIST = 'get game list';
    const GET_GAME = 'get game';
    const POST_GAME = 'post game';
    const PATCH_GAME = 'patch game';

    const GET_PLAYER = 'get player';
    const POST_PLAYER = 'post player';
}
