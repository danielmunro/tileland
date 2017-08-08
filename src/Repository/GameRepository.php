<?php
declare(strict_types=1);

namespace TileLand\Repository;

use TileLand\Entity\Game;
use TileLand\Entity\Player;

interface GameRepository
{
    public function findByPlayer(Player $player): array;

    public function findById(int $id): ?Game;
}
