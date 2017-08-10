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

/**
 * https://silex.symfony.com/doc/2.0/usage.html
 * convert game ID to game entity
 */
$app->mount('/games', function (\Silex\ControllerCollection $games) use ($app) {
    $games->options('', 'games.controller:getListOptions');
    $games->get('', 'games.controller:getList')->bind(URL_GAME_LIST);
    $games->mount('/{game}', function (\Silex\ControllerCollection $game) use ($app) {
        $game->get('', 'games.controller:getGame')->bind(URL_GAME_INFO);
        $game->options('', 'games.controller:getGameOptions');
        $game->patch('', 'games.controller:startGame')->bind('startGame');
        $game->post('/players', 'games.controller:addPlayer')->bind(URL_GAME_ADD_PLAYER);
        $game->mount('/players', function (\Silex\ControllerCollection $players) use ($app) {
            $players->options('', 'games.controller:getPlayerOptions');
            $players->get('/{player}', 'games.controller:getPlayer')->bind(URL_GAME_PLAYER_INFO);
            $players->convert('player', function (int $playerId) use ($app) {
                /** @var \Doctrine\ORM\EntityManager $em */
                $em = $app['em'];
                /** @var \TileLand\Repository\PlayerRepository $playerRepository */
                $playerRepository = $em->getRepository(\TileLand\Entity\Player::class);
                $player = $playerRepository->findById($playerId);

                if (!$player) {
                    throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException(
                        'Player not found'
                    );
                }

                return $player;
            });
        });
        $game->convert('game', function (int $gameId) use ($app) {
            /** @var \Doctrine\ORM\EntityManager $em */
            $em = $app['em'];
            /** @var \TileLand\Repository\GameRepository $gameRepository */
            $gameRepository = $em->getRepository(\TileLand\Entity\Game::class);
            $game = $gameRepository->findById($gameId);

            if (!$game) {
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException(
                    'Game not found'
                );
            }

            return $game;
        });
    });
});

$app['controllers']->assert('game', '\d+');
$app['controllers']->assert('player', '\d+');

$app->view(function (\League\Fractal\Resource\ResourceAbstract $resource, \Symfony\Component\HttpFoundation\Request $request) {
    $manager = new \League\Fractal\Manager();
    $manager->setSerializer(new \League\Fractal\Serializer\DataArraySerializer());
    \Functional\with(
        $request->get('include'),
        function (string $include) use ($manager) {
            $manager->parseIncludes($include);
        }
    );

    return new \Symfony\Component\HttpFoundation\JsonResponse(
        $manager->createData($resource)->toArray()
    );
});

$app->run();
