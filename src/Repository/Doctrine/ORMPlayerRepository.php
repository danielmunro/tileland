<?php
declare(strict_types=1);

namespace TileLand\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;
use TileLand\Entity\Game;
use TileLand\Entity\Player;
use TileLand\Repository\PlayerRepository;

class ORMPlayerRepository extends EntityRepository implements PlayerRepository
{
    public function findById(int $id): ?Player
    {
        return $this->find($id);
    }

    public function findByGame(Game $game): array
    {
        return $this->findBy(['game' => $game]);
    }
}
