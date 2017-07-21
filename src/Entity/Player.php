<?php
declare(strict_types=1);

namespace TileLand\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use TileLand\Enum\Civilization;

/**
 * @Entity
 */
class Player
{
    use PrimaryKeyTrait;

    /**
     * @var Civilization
     * @Column(type="string")
     */
    protected $civilization;

    /**
     * @var Collection
     * @OneToMany(targetEntity="Tile", mappedBy="owner")
     */
    protected $tiles;

    /**
     * @var Collection
     * @OneToMany(targetEntity="City", mappedBy="owner")
     */
    protected $cities;

    /**
     * @var Collection
     * @OneToMany(targetEntity="Unit", mappedBy="owner")
     */
    protected $units;

    /**
     * @var bool
     * @Column(type="boolean")
     */
    protected $isHuman;

    /**
     * @var Game
     * @ManyToOne(targetEntity="Game", inversedBy="players")
     */
    protected $game;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $turn;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $gold;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $science;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $culture;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $military;

    public function __construct(Civilization $civilization, bool $isHuman)
    {
        $this->civilization = $civilization->getValue();
        $this->isHuman = $isHuman;
        $this->tiles = new ArrayCollection();
        $this->units = new ArrayCollection();
        $this->cities = new ArrayCollection();
        $this->turn = 0;
    }

    public function getCivilization(): Civilization
    {
        return new Civilization($this->civilization);
    }

    /**
     * @return Unit[]
     */
    public function getUnits(): Collection
    {
        return $this->units;
    }

    public function addUnit(Unit $unit): void
    {
        $this->units->add($unit);
    }

    /**
     * @return City[]
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): void
    {
        $this->cities->add($city);
    }

    public function incrementTurn(): int
    {
        $this->turn++;

        return $this->turn;
    }

    public function getTurn(): int
    {
        return $this->turn;
    }
}
