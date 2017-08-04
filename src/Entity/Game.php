<?php
declare(strict_types=1);

namespace TileLand\Entity;

use Doctrine\Common\Collections\Collection;

/**
 * @Entity
 */
class Game
{
    use PrimaryKeyTrait;

    /**
     * @var Collection
     * @OneToMany(targetEntity="Player", mappedBy="game")
     */
    protected $players;
}
