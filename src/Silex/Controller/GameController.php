<?php
declare(strict_types=1);

namespace TileLand\Silex\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceAbstract;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use TileLand\Doctrine\EntityPersister;
use TileLand\Entity\Game;
use TileLand\Entity\Player;
use TileLand\Entity\World;
use TileLand\Exception\GameStartedException;
use TileLand\Exception\NoPlayersException;
use TileLand\Repository\GameRepository;
use TileLand\Transformer\GameTransformer;

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

    public function postGame(): ResourceAbstract
    {
        $world = new World();
        $game = new Game(new ArrayCollection(), $world);
        $this->entityPersister->persist($game);
        $this->entityPersister->persist($world);
        $this->entityPersister->flush();

        return new Item($game, new GameTransformer($this->urlGenerator));
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
            ['GET', 'PATCH', 'POST']
        );
    }

    public function startGame(Game $game): ResourceAbstract
    {
        try {
            $game->startGame();
        } catch (GameStartedException $e) {
            throw new ConflictHttpException(
                $e->getMessage(),
                $e
            );
        } catch (NoPlayersException $e) {
            throw new PreconditionFailedHttpException(
                $e->getMessage(),
                $e
            );
        }

        $this->entityPersister->persist($game);
        $this->entityPersister->flush();

        return new Item($game, new GameTransformer($this->urlGenerator));
    }

    public function createCity(Game $game, Request $request): JsonResponse
    {
        return new JsonResponse();
    }
}
