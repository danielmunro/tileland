<?php
declare(strict_types=1);

namespace TileLand\Silex\Controller;

use League\Fractal\Resource\Collection;
use League\Fractal\Resource\ResourceAbstract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use TileLand\Doctrine\EntityPersister;
use TileLand\Entity\Game;
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
}
