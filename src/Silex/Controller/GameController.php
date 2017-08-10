<?php
declare(strict_types=1);

namespace TileLand\Silex\Controller;

use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceAbstract;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use TileLand\Civilization\TestCivilization;
use TileLand\Doctrine\EntityPersister;
use TileLand\Entity\Game;
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

    public function getList(): ResourceAbstract
    {
        return new Collection(
            $this->gameRepository->findByPlayer($this->player),
            new GameTransformer($this->urlGenerator)
        );
    }

    public function getListOptions(): JsonResponse
    {
        return new JsonResponse(['GET']);
    }

    public function getGame(Game $game): ResourceAbstract
    {
        return new Item(
            $game,
            new GameTransformer($this->urlGenerator)
        );
    }

    public function getGameOptions(): JsonResponse
    {
        return new JsonResponse(
            ['GET', 'PATCH']
        );
    }

    public function addPlayer(Game $game): JsonResponse
    {
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

    public function getPlayer(Player $player): ResourceAbstract
    {
        return new Item(
            $player,
            new PlayerTransformer($this->urlGenerator)
        );
    }

    public function getPlayerOptions(): JsonResponse
    {
        return new JsonResponse(
            ['POST', 'GET']
        );
    }

    public function createCity(Game $game, Request $request): JsonResponse
    {
        return new JsonResponse();
    }
}
