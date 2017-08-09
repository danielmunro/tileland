<?php
declare(strict_types=1);

namespace TileLand\Silex\Controller;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\Serializer\DataArraySerializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;
use TileLand\Civilization\TestCivilization;
use TileLand\Doctrine\EntityPersister;
use TileLand\Entity\Player;
use TileLand\Repository\GameRepository;
use TileLand\Transformer\GameTransformer;
use TileLand\Transformer\PlayerTransformer;

class GameController
{
    protected $entityPersister;

    protected $urlGenerator;

    protected $gameRepository;

    protected $player;

    public function __construct(
        EntityPersister $entityPersister,
        UrlGenerator $urlGenerator,
        GameRepository $gameRepository,
        Player $player
    ) {
        $this->entityPersister = $entityPersister;
        $this->urlGenerator = $urlGenerator;
        $this->gameRepository = $gameRepository;
        $this->player = $player;
    }

    public function getList(): JsonResponse
    {
        return new JsonResponse(
            self::createResourceData(
                new Collection(
                    $this->gameRepository->findByPlayer($this->player),
                    new GameTransformer($this->urlGenerator)
                )
            )
        );
    }

    public function getListOptions(): JsonResponse
    {
        return new JsonResponse(['GET']);
    }

    public function getGame(int $gameId): Response
    {
        $game = $this->gameRepository->findById($gameId);

        if (!$game) {
            return new Response(
                'game not found!',
                404
            );
        }

        return new JsonResponse(
            self::createResourceData(
                new Item(
                    $game,
                    new GameTransformer($this->urlGenerator)
                )
            )
        );
    }

    public function getGameOptions(): JsonResponse
    {
        return new JsonResponse(
            ['GET', 'PATCH']
        );
    }

    public function addPlayer(int $gameId): JsonResponse
    {
        $game = $this->gameRepository->findById($gameId);

        if (!$game) {
            return new JsonResponse(
                ['message' => 'Game not found!'],
                404
            );
        }

        $player = new Player($game, new TestCivilization(), true);
        $game->addPlayer($player);
        $this->entityPersister->persist($player);
        $this->entityPersister->flush();

        return new JsonResponse(
            [
                'message' => 'Player added.',
            ],
            201
        );
    }

    public function getPlayer(int $gameId, int $playerId): JsonResponse
    {
        $game = $this->gameRepository->findById($gameId);

        if (!$game) {
            return new JsonResponse(
                ['message' => 'Game not found!'],
                404
            );
        }

        $player = $game->getPlayers()->filter(function (Player $player) use ($playerId) {
            return $player->getId() == $playerId;
        })->first();

        if (!$player) {
            return new JsonResponse(
                ['message' => 'Player not found!'],
                404
            );
        }

        return new JsonResponse(
            self::createResourceData(
                new Item(
                    $player,
                    new PlayerTransformer($this->urlGenerator)
                )
            )
        );
    }

    public function getPlayerOptions(): JsonResponse
    {
        return new JsonResponse(
            ['POST']
        );
    }

    private static function getFractalManager(): Manager
    {
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());

        return $manager;
    }

    private static function createResourceData(ResourceAbstract $resourceAbstract): array
    {
        return self::getFractalManager()->createData(
            $resourceAbstract
        )->toArray();
    }

}