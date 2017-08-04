<?php
declare(strict_types=1);

namespace TileLand\Player;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use function Functional\reduce_left;
use TileLand\Entity\City;
use TileLand\Entity\Player;
use TileLand\Enum\TurnStatus;
use TileLand\Player\Action\Action;

class Turn
{
    /**
     * @var Player
     */
    protected $player;

    /**
     * @var Collection
     */
    protected $actions;

    /**
     * @var TurnStatus
     */
    protected $status;

    public function __construct(Player $player)
    {
        $this->player = $player;
        $this->actions = new ArrayCollection();
        $this->setStatus(TurnStatus::INITIALIZED());
    }

    public function start(): void
    {
        $this->setStatus(TurnStatus::IN_PLAY());

        $this->player->debitGold(
            reduce_left(
                $this->player->getCities()->toArray(),
                function (City $city, int $index, array $cities, int $initial) {
                    return $initial + $city->getMaintenanceCostInGold();
                },
                0
            )
        );

        foreach ($this->player->getCities() as $city) {
            /** @var City $city */
            if ($city->getProduction() && $city->reduceProductionCost() === 0) {
                $city->completeProduction();
            }
        }

        foreach ($this->player->getUnits() as $unit) {
            $unit->regenAttributesOnTurnStart();
        }
    }

    public function addAction(Action $actionToAdd): void
    {
        if (!$this->status->equals(TurnStatus::IN_PLAY())) {
            throw new \RuntimeException('must be in play to add an action to a turn');
        }

        $this->actions = $this->actions->filter(function (Action $actionPerformed) use ($actionToAdd) {
            return $actionPerformed->getActionCreator() !== $actionToAdd->getActionCreator();
        });

        $this->actions->add($actionToAdd);
    }

    public function end(): int
    {
        $this->actions->forAll(function (int $i, Action $action) {
            /**
             * @todo implement what happens when interrupted
             */
            $action->consume();
        });
        $this->actions = new ArrayCollection();
        $this->setStatus(TurnStatus::ENDED());

        return $this->player->incrementTurn();
    }

    protected function setStatus(TurnStatus $status): void
    {
        $this->status = $status;
    }
}
