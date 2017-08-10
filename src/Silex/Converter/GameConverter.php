<?php
declare(strict_types=1);

namespace TileLand\Silex\Converter;

use Symfony\Component\HttpFoundation\Request;
use TileLand\Entity\Game;
use TileLand\Repository\GameRepository;

class GameConverter
{
    protected $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function __invoke(?int $gameId, Request $request): ?Game
    {
        $useGameId = $gameId ?? (int) $request->get('game');

        return $useGameId ? $this->gameRepository->findById($useGameId) : null;
    }
}
