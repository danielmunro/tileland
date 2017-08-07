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

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $turn;

    /**
     * @var Player
     * @OneToOne(targetEntity="Player")
     */
    protected $currentPlayerTurn;

    /**
     * @var World
     * @OneToOne(targetEntity="World")
     */
    protected $world;

    public function __construct(Collection $players, World $world)
    {
        $this->players = $players;
        $this->world = $world;
        $this->turn = 0;
        $this->currentPlayerTurn = null;
    }

    public function getCurrentPlayerTurn(): Player
    {
        return $this->currentPlayerTurn;
    }

    public function startGame(): void
    {
        $this->incrementTurn();
    }

    public function endCurrentPlayerTurn(): void
    {
        $index = $this->players->indexOf($this->currentPlayerTurn);

        if ($this->players->containsKey($index + 1)) {
            $this->currentPlayerTurn = $this->players->get($index + 1);

            return;
        }

        $this->incrementTurn();
    }

    protected function incrementTurn(): void
    {
        $this->turn++;
        $this->currentPlayerTurn = $this->players->first();
    }
}
