<?php
declare(strict_types=1);

namespace TileLand\Transformer;

use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Symfony\Component\Routing\Generator\UrlGenerator;
use TileLand\Entity\Game;

class GameTransformer extends TransformerAbstract
{
    protected $urlGenerator;

    protected $defaultIncludes = [
        'players',
    ];

    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function includePlayers(Game $game): Collection
    {
        return $this->collection($game->getPlayers(), new PlayerTransformer($this->urlGenerator));
    }

    public function transform(Game $game): array
    {
        return [
            'id' => $game->getId(),
            'turn' => $game->getTurn(),
            'currentPlayer' => $game->getCurrentPlayer(),
            'links' => [
                'self' => $this->urlGenerator->generate(
                    URL_GAME_INFO,
                    [
                        'gameId' => $game->getId()
                    ]
                ),
            ],
        ];
    }
}
