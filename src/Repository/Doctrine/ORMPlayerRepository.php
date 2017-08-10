<?php
declare(strict_types=1);

namespace TileLand\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;
use TileLand\Entity\Player;
use TileLand\Repository\PlayerRepository;

class ORMPlayerRepository extends EntityRepository implements PlayerRepository
{
    public function findById(int $id): ?Player
    {
        return $this->find($id);
    }
}
