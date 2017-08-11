<?php
declare(strict_types=1);

namespace TileLand\Entity;

use Doctrine\Common\Collections\Collection;
use TileLand\Exception\GameStartedException;
use TileLand\Exception\NoPlayersException;

/**
 * @Entity(repositoryClass="\TileLand\Repository\Doctrine\ORMGameRepository")
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
    protected $currentPlayer;

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
        $this->currentPlayer = null;
    }

    public function hasBegun(): bool
    {
        return $this->turn > 0;
    }

    public function addPlayer(Player $player): void
    {
        if ($this->hasBegun()) {
            throw new \RuntimeException('Game has already begun!');
        }

        $this->players->add($player);
    }

    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function getCurrentPlayer(): ?Player
    {
        return $this->currentPlayer;
    }

    public function getCurrentPlayerTurn(): int
    {
        return $this->currentPlayer ? $this->currentPlayer->getTurn() : -1;
    }

    public function startGame(): void
    {
        if ($this->hasBegun()) {
            throw new GameStartedException('Game has already started');
        }

        if ($this->players->isEmpty()) {
            throw new NoPlayersException('Cannot start a game without players');
        }

        $this->incrementTurn();
    }

    public function endCurrentPlayerTurn(): void
    {
        $index = $this->players->indexOf($this->currentPlayer);

        if ($this->players->containsKey($index + 1)) {
            $this->currentPlayer = $this->players->get($index + 1);

            return;
        }

        $this->incrementTurn();
    }

    public function getTurn(): int
    {
        return $this->turn;
    }

    protected function incrementTurn(): void
    {
        $this->turn++;
        $this->currentPlayer = $this->players->first();
    }
}
