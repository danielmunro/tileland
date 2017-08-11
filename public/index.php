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
use TileLand\Silex\ErrorHandler\JsonErrorHandler;

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
/** @var \Doctrine\ORM\EntityManager $em */
$em = $app['em'];
/** @var \TileLand\Repository\GameRepository $gameRepository */
$gameRepository = $em->getRepository(\TileLand\Entity\Game::class);
/** @var \TileLand\Repository\PlayerRepository $playerRepository */
$playerRepository = $em->getRepository(\TileLand\Entity\Player::class);

$app['games.controller'] = function () use ($app, $em, $gameRepository, $playerRepository) {
    return new GameController(
        new EntityPersister($em),
        $app['url_generator'],
        $gameRepository,
        $playerRepository->findById(3) /** @todo remove hardcoded id */
    );
};

$app['players.controller'] = function () use ($app, $em, $playerRepository) {
    return new PlayerController(
        new EntityPersister($em),
        $playerRepository,
        $app['url_generator']
    );
};

/**
 * https://silex.symfony.com/doc/2.0/usage.html
 * convert game ID to game entity
 */
$app->mount('/games', new GamesControllerMount($gameRepository, $playerRepository));
$app->mount('/players', new PlayersControllerMount($playerRepository));

/** @var \Silex\ControllerCollection $controllerCollection */
$controllerCollection = $app['controllers'];
$controllerCollection->assert('game', '\d+')
    ->convert('game', new GameConverter($gameRepository));
$controllerCollection->assert('player', '\d+')
    ->convert('player', new PlayerConverter($playerRepository));

$app->view(new JsonView());
$app->error(new JsonErrorHandler());
$app->run();
