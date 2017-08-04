<?php
declare(strict_types=1);

namespace TileLand\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use function Functional\first;
use TileLand\Direction\Direction;
use TileLand\Enum\Improvement;
use TileLand\Enum\Resource;
use TileLand\Enum\Terrain;

/**
 * @Entity
 */
class Tile
{
    use PrimaryKeyTrait;

    /**
     * @var ArrayCollection
     * @OneToMany(targetEntity="Edge", mappedBy="fromTile")
     */
    protected $edges;

    /**
     * @var Improvement|null
     * @Column(type="string", nullable=true)
     */
    protected $improvement;

    /**
     * @var Terrain
     * @Column(type="string")
     */
    protected $terrain;

    /**
     * @var Resource
     * @Column(type="string", nullable=true)
     */
    protected $resource;

    /**
     * @var Player
     * @ManyToOne(targetEntity="Player", inversedBy="tiles")
     */
    protected $owner;

    /**
     * @var City
     * @OneToOne(targetEntity="City", inversedBy="tile")
     */
    protected $city;

    /**
     * @var Collection
     * @OneToMany(targetEntity="Unit", mappedBy="tile")
     */
    protected $units;

    public function __construct(Terrain $terrain, Resource $resource = null)
    {
        $this->edges = new ArrayCollection();
        $this->units = new ArrayCollection();
        $this->terrain = $terrain->getValue();
        if ($resource) {
            $this->resource = $resource->getValue();
        }
    }

    public function getResource(): ?Resource
    {
        return $this->resource ? new Resource($this->resource) : null;
    }

    public function addEdge(Edge $edge): void
    {
        $this->edges->add($edge);
    }

    public function getEdges(): Collection
    {
        return $this->edges;
    }

    public function getEdge(Direction $direction): ?Edge
    {
        return first(
            $this->edges->toArray(),
            function (Edge $edge) use ($direction) {
                return $edge->isDirection($direction);
            }
        );
    }

    public function getTerrain(): Terrain
    {
        return new Terrain($this->terrain);
    }

    public function isTerrain(Terrain $terrain): bool
    {
        return (new Terrain($this->terrain))->equals($terrain);
    }

    public function setCity(City $city): void
    {
        if ($this->city) {
            throw new \RuntimeException('City already exists on this tile');
        }

        $this->city = $city;
        $city->setTile($this);
    }

    public function addUnit(Unit $unit): void
    {
        $this->units->add($unit);
        $unit->setTile($this);
    }

    public function removeUnit(Unit $unit): void
    {
        $this->units->removeElement($unit);
    }

    public function getUnits(): Collection
    {
        return $this->units;
    }

    public function __toString()
    {
        return (string) $this->id;
    }

    public function __debugInfo()
    {
        return [
            'id' => $this->id,
        ];
    }
}
