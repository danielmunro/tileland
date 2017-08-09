<?php
declare(strict_types=1);

namespace TileLand\Transformer;

use League\Fractal\TransformerAbstract;
use Symfony\Component\Routing\Generator\UrlGenerator;
use TileLand\Entity\Player;

class PlayerTransformer extends TransformerAbstract
{
    protected $urlGenerator;

    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }
    public function transform(Player $player): array
    {
        return [
            'id' => $player->getId(),
            'turn' => $player->getTurn(),
            'civilization' => $player->getCivilization(),
            'cities' => [],//$player->getCities(),
            'links' => [
                'self' => $this->urlGenerator->generate(
                    URL_GAME_PLAYER_INFO,
                    [
                        'playerId' => $player->getId(),
                        'gameId' => $player->getGameId(),
                    ]
                )
            ],
        ];
    }
}