<?php
declare(strict_types=1);

namespace TileLand\Silex\Converter;

use TileLand\Entity\Player;
use TileLand\Repository\PlayerRepository;

class PlayerConverter
{
    protected $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function __invoke(?int $playerId): ?Player
    {
        return $playerId ? $this->playerRepository->findById($playerId) : null;
    }
}
