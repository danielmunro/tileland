<?php
declare(strict_types=1);

namespace TileLand\Repository;

use TileLand\Entity\Player;

interface PlayerRepository
{
    public function findById(int $id): ?Player;
}
