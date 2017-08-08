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

define('URL_GAME_INFO', 'gameInfo');

$app->get('/games', 'games.controller:getList')
    ->bind('gameList');

$app->get('/games/{gameId}', 'games.controller:getGame')
    ->bind(URL_GAME_INFO);

$app->post('/games/{gameId}/player', 'games.controller:addPlayer')
    ->bind('addPlayer');

$app->patch('/games/{gameId}', 'games.controller:startGame')
    ->bind('startGame');

$app['controllers']->assert('gameId', '\d+');

$app->run();
