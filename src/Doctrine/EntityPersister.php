<?php
declare(strict_types=1);

namespace TileLand\Doctrine;

use Doctrine\ORM\EntityManager;

class EntityPersister
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function persist($entity): void
    {
        $this->em->persist($entity);
    }

    public function flush(): void
    {
        $this->em->flush();
    }
}
