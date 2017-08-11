<?php
declare(strict_types=1);

namespace TileLand\Silex\ControllerMount;

use Silex\ControllerCollection;
use TileLand\Enum\Url;
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
        $players->options('', 'players.controller:getPlayerOptions');
        $players->post('', 'players.controller:postPlayer')
            ->bind(Url::POST_PLAYER);
        $players->get('', 'players.controller:getPlayers');
        $players->get('/{player}', 'players.controller:getPlayer')
            ->bind(Url::GET_PLAYER);
        $players->convert('player', new PlayerConverter($this->playerRepository));
    }
}
