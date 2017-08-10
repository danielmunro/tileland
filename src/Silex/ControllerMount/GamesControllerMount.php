<?php
declare(strict_types=1);

namespace TileLand\Silex\ControllerMount;

use Silex\ControllerCollection;
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
        $games->get('', 'games.controller:getList')->bind(URL_GAME_LIST);
        $games->mount('/{game}', function (ControllerCollection $game) {
            $game->get('', 'games.controller:getGame')->bind(URL_GAME_INFO);
            $game->options('', 'games.controller:getGameOptions');
            $game->patch('', 'games.controller:startGame')->bind('startGame');
        });
    }
}
