<?php
declare(strict_types=1);

namespace TileLand\Silex\ControllerMount;

use Silex\ControllerCollection;
use TileLand\Repository\PlayerRepository;
use TileLand\Silex\Converter\PlayerConverter;

class PlayersControllerMount
{
    protected $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function __invoke(ControllerCollection $players)
    {
        $players->post('', 'games.controller:addPlayer')->bind(URL_GAME_ADD_PLAYER);
        $players->options('', 'games.controller:getPlayerOptions');
        $players->get('', 'players.controller:getPlayers');
        $players->get('/{player}', 'games.controller:getPlayer')->bind(URL_GAME_PLAYER_INFO);
        $players->convert('player', new PlayerConverter($this->playerRepository));
    }
}
