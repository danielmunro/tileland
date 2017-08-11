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
use TileLand\Repository\PlayerRepository;
use TileLand\Transformer\PlayerTransformer;

class PlayerController
{
    protected $entityPersister;

    protected $playerRepository;

    protected $urlGenerator;

    public function __construct(
        EntityPersister $entityPersister,
        PlayerRepository $playerRepository,
        UrlGenerator $urlGenerator
    ) {
        $this->entityPersister = $entityPersister;
        $this->playerRepository = $playerRepository;
        $this->urlGenerator = $urlGenerator;
    }

    public function getPlayers(Game $game): ResourceAbstract
    {
        return new Collection(
            $this->playerRepository->findByGame($game),
            new PlayerTransformer($this->urlGenerator)
        );
    }

    public function postPlayer(Game $game): ResourceAbstract
    {
        $player = new Player($game, new TestCivilization(), true);
        try {
            $game->addPlayer($player);
        } catch (\RuntimeException $e) {
            throw new \HttpRequestException(
                'Game has already started',
                409,
                $e
            );
        }
        $this->entityPersister->persist($player);
        $this->entityPersister->flush();

        return new Item($player, new PlayerTransformer($this->urlGenerator));
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
}
