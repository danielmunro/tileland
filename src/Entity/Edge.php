<?php
declare(strict_types=1);

namespace TileLand\Entity;

use TileLand\Direction\Direction;

/**
 * @Entity
 */
class Edge
{
    use PrimaryKeyTrait;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $direction;

    /**
     * @var Tile
     * @ManyToOne(targetEntity="Tile", inversedBy="edges")
     */
    protected $fromTile;

    /**
     * @var Tile
     * @OneToOne(targetEntity="Tile")
     */
    protected $toTile;

    public function __construct(Direction $direction, Tile $fromTile, Tile $toTile)
    {
        $this->direction = $direction->getName();
        $this->fromTile = $fromTile;
        $this->toTile = $toTile;
    }

    public function isDirection(Direction $direction): bool
    {
        return $this->direction === $direction->getName();
    }

    public function getFromTile(): Tile
    {
        return $this->fromTile;
    }

    public function getToTile(): Tile
    {
        return $this->toTile;
    }
}
