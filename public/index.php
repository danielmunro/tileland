<?php

require_once __DIR__ . '/../bootstrap.php';

use TileLand\Silex\Controller\GameController;
use TileLand\Silex\Controller\PlayerController;
use TileLand\Doctrine\EntityPersister;
use TileLand\Silex\View\JsonView;
use TileLand\Silex\ControllerMount\GamesControllerMount;
use TileLand\Silex\ControllerMount\PlayersControllerMount;
use TileLand\Silex\Converter\GameConverter;
use TileLand\Silex\Converter\PlayerConverter;

/**
 * ENDPOINTS
 *
 * /games
 * -- GET /
 * -- GET /{gameId}
 * -- POST /
 * -- DELETE /{gameId}
 *
 * /games/{gameId}/players
 * -- GET /
 * -- GET /{playerId}
 * -- POST /{playerId}
 * -- DELETE /{playerId}
 *
 * /players
 * -- GET /
 * -- GET /{playerId}
 * -- POST /
 * -- PATCH /{playerId}
 * -- DELETE /{playerId}
 *
 * /players/{playerId}/cities
 * -- GET /
 * -- GET /{cityId}
 * -- POST /
 * -- PATCH /{cityId}
 * -- DELETE /{cityId}
 *
 * /players/{playerId}/units
 * -- GET /
 * -- GET /{unitId}
 * -- POST /
 * -- PATCH /{unitId}
 * -- DELETE /{unitId}
 *
 * /turns
 * -- GET /{gameId}
 * -- GET /{gameId}/{turnId}
 * -- POST /{gameId}/{turnId}
 * -- PATCH /{gameId}/{turnId}
 */

$app['games.controller'] = function () use ($app) {
    /** @var \Doctrine\ORM\EntityManager $em */
    $em = $app['em'];
    return new GameController(
        new EntityPersister($em),
        $app['url_generator'],
        $em->getRepository(\TileLand\Entity\Game::class),
        $em->getRepository(\TileLand\Entity\Player::class)->find(3)
    );
};

$app['players.controller'] = function () use ($app) {
    /** @var \Doctrine\ORM\EntityManager $em */
    $em = $app['em'];
    return new PlayerController(
        new EntityPersister($em),
        $em->getRepository(\TileLand\Entity\Player::class),
        $app['url_generator']
    );
};

define('URL_GAME_LIST', 'gameList');
define('URL_GAME_INFO', 'gameInfo');
define('URL_GAME_PLAYER_INFO', 'playerInfo');
define('URL_GAME_ADD_PLAYER', 'addPlayer');

/**
 * https://silex.symfony.com/doc/2.0/usage.html
 * convert game ID to game entity
 */
/** @var \Doctrine\ORM\EntityManager $em */
$em = $app['em'];
$gameRepository = $em->getRepository(\TileLand\Entity\Game::class);
$playerRepository = $em->getRepository(\TileLand\Entity\Player::class);
$app->mount(
    '/games',
    new GamesControllerMount($gameRepository, $playerRepository)
);
$app->mount(
    '/players',
    new PlayersControllerMount($playerRepository)
);

/** @var \Silex\ControllerCollection $controllerCollection */
$controllerCollection = $app['controllers'];
$controllerCollection->assert('game', '\d+');
$controllerCollection->assert('player', '\d+');
$controllerCollection->convert('game', new GameConverter($gameRepository));
$controllerCollection->convert('player', new PlayerConverter($playerRepository));

$app->view(new JsonView());
$app->run();
