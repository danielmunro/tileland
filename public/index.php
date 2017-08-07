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

$app->get('/', function () use ($app) {
    /** @var \Doctrine\ORM\EntityManager $em */
    $em = $app['em'];
    $games = $em->getRepository(\TileLand\Entity\Game::class)->findAll();
    foreach ($games as $game) {
        /** @var \TileLand\Entity\Game $game */
        echo $game->getId()."\n";
    }

    return new \Symfony\Component\HttpFoundation\Response(
        ''
    );
});

$app->run();
