<?php
declare(strict_types=1);

namespace TileLand\Silex\ControllerMount;

use Silex\ControllerCollection;
use TileLand\Enum\Url;
use TileLand\Repository\GameRepository;
use TileLand\Repository\PlayerRepository;

class GamesControllerMount
{
    protected $gameRepository;

    protected $playerRepository;

    public function __construct(GameRepository $gameRepository, PlayerRepository $playerRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->playerRepository = $playerRepository;
    }

    public function __invoke(ControllerCollection $games)
    {
        $games->options('', 'games.controller:getListOptions');
        $games->post('', 'games.controller:postGame')->bind(Url::POST_GAME);
        $games->get('', 'games.controller:getList')->bind(Url::GET_GAME_LIST);
        $games->mount('/{game}', function (ControllerCollection $game) {
            $game->get('', 'games.controller:getGame')->bind(Url::GET_GAME);
            $game->options('', 'games.controller:getGameOptions');
            $game->patch('', 'games.controller:startGame')->bind(Url::PATCH_GAME);
        });
    }
}
