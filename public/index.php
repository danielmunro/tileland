<?php

require_once __DIR__ . '/../bootstrap.php';

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
    return new \TileLand\Silex\Controller\GameController(
        new \TileLand\Doctrine\EntityPersister($em),
        $app['url_generator'],
        $em->getRepository(\TileLand\Entity\Game::class),
        $em->getRepository(\TileLand\Entity\Player::class)->find(3)
    );
};

define('URL_GAME_LIST', 'gameList');
define('URL_GAME_INFO', 'gameInfo');
define('URL_GAME_PLAYER_INFO', 'playerInfo');
define('URL_GAME_ADD_PLAYER', 'addPlayer');

$app->mount('/games', function (\Silex\ControllerCollection $games) {
    $games->options('', 'games.controller:getListOptions');
    $games->get('', 'games.controller:getList')->bind(URL_GAME_LIST);
    $games->get('/{gameId}', 'games.controller:getGame')->bind(URL_GAME_INFO);
    $games->mount('/{gameId}', function (\Silex\ControllerCollection $game) {
        $game->options('', 'games.controller:getGameOptions');
        $game->patch('', 'games.controller:startGame')->bind('startGame');
        $game->post('/players', 'games.controller:addPlayer')->bind(URL_GAME_ADD_PLAYER);
        $game->mount('/players', function (\Silex\ControllerCollection $players) {
            $players->options('', 'games.controller:getPlayerOptions');
            $players->get('/{playerId}', 'games.controller:getPlayer')->bind(URL_GAME_PLAYER_INFO);
        });
    });
});

$app['controllers']->assert('gameId', '\d+');
$app['controllers']->assert('playerId', '\d+');

$app->run();
