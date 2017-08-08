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

    public function getList(): Response
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

    public function addPlayer(int $gameId): Response
    {
        $game = $this->gameRepository->findById($gameId);

        if (!$game) {
            return new Response(
                'Game not found!',
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