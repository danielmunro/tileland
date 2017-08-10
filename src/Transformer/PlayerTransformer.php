<?php
declare(strict_types=1);

namespace TileLand\Transformer;

use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
use Symfony\Component\Routing\Generator\UrlGenerator;
use TileLand\Entity\Player;

class PlayerTransformer extends TransformerAbstract
{
    protected $urlGenerator;

    protected $availableIncludes = [
        'cities',
    ];

    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function includeCities(Player $player): Collection
    {
        return $this->collection($player->getCities(), new CityTransformer($this->urlGenerator));
    }

    public function transform(Player $player): array
    {
        return [
            'id' => $player->getId(),
            'turn' => $player->getTurn(),
            'civilization' => $player->getCivilization(),
            'links' => [
                'self' => $this->urlGenerator->generate(
                    URL_GAME_PLAYER_INFO,
                    [
                        'player' => $player->getId(),
                        'game' => $player->getGameId(),
                    ]
                )
            ],
        ];
    }
}
