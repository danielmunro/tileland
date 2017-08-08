<?php
declare(strict_types=1);

namespace TileLand\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use TileLand\Entity\Game;
use TileLand\Entity\Player;
use TileLand\Repository\GameRepository;

class ORMGameRepository extends EntityRepository implements GameRepository
{
    public function findByPlayer(Player $player): array
    {
        $qb = $this->_em->createQueryBuilder();
        return $qb->select('g')
            ->from(Game::class, 'g')
            ->join('g.players', 'p', Join::WITH, $qb->expr()->eq('p', ':player'))
            ->setParameter('player', $player)
            ->getQuery()
            ->getResult();
    }

    public function findById(int $id): ?Game
    {
        return $this->find($id);
    }
}
