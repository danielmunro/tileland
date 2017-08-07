<?php
declare(strict_types=1);

namespace TileLand\Entity;

use Doctrine\Common\Collections\Collection;

/**
 * @Entity
 */
class World
{
    use PrimaryKeyTrait;

    /**
     * @var Collection
     */
    protected $tiles;
}
