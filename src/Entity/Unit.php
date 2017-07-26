<?php
declare(strict_types=1);

namespace TileLand\Entity;

use function Functional\with;
use TileLand\Enum\ActionStatus;
use TileLand\Enum\ActionType;
use TileLand\Enum\UnitType;
use TileLand\City\Producible;
use TileLand\Player\Action\Action;
use TileLand\Player\Action\ActionCreator;
use TileLand\Player\Action\ActionResult;
use TileLand\Player\ActionContext\ActionContext;
use TileLand\Player\ActionContext\CommandActionContext;
use TileLand\Unit\Attack;
use TileLand\Unit\UnitFactory;

/**
 * @Entity
 */
class Unit implements Producible, ActionCreator
{
    use PrimaryKeyTrait;

    /**
     * @var UnitType
     * @Column(type="string")
     */
    protected $type;

    /**
     * @var UnitAttributes
     * @OneToOne(targetEntity="UnitAttributes")
     */
    protected $attributes;

    /**
     * @var Tile
     * @ManyToOne(targetEntity="Tile", inversedBy="units")
     */
    protected $tile;

    /**
     * @var Player
     * @ManyToOne(targetEntity="Player", inversedBy="units")
     */
    protected $owner;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $baseProductionCost;

    public function __construct(\TileLand\Unit\Unit $unit, UnitAttributes $attributes)
    {
        $this->type = $unit->getName();
        $this->attributes = $attributes;
        $this->baseProductionCost = 1;
    }

    public function attack(Unit $unit): Attack
    {
        return new Attack(
            $this,
            $unit,
            with(
                max(0, $this->attributes->getDamageRoll() - $unit->getArmorClass()),
                function ($damage) use ($unit) {
                    $unit->receiveDamage($damage);

                    return $damage;
                }
            )
        );
    }

    public function getUnitType(): \TileLand\Unit\Unit
    {
        return UnitFactory::createUnitFromName($this->type);
    }

    public function getHp(): int
    {
        return $this->attributes->getHp();
    }

    public function getMaxHp(): int
    {
        return $this->attributes->getMaxHp();
    }

    public function getMv(): int
    {
        return $this->attributes->getMv();
    }

    public function getMaxMv(): int
    {
        return $this->attributes->getMaxMv();
    }

    public function getArmorClass(): int
    {
        return $this->attributes->getArmorClass();
    }

    public function receiveDamage(int $damage): void
    {
        $this->attributes->receiveDamage($damage);
    }

    public function consumeMovement(): void
    {
        $this->attributes->consumeMovement();
    }

    public function regenAttributesOnTurnStart(): void
    {
        $this->attributes->regenHp();
        $this->attributes->regenMv();
    }

    public function getBaseProductionCost(): int
    {
        return $this->baseProductionCost;
    }

    public function completed(City $city): void
    {
        $city->addCompletedUnitToTile($this);
        $city->resetProduction();
    }

    /**
     * @param Action $action
     * @param CommandActionContext $actionContext
     * @return ActionResult
     */
    public function performAction(Action $action, ActionContext $actionContext): ActionResult
    {
        /** @var ActionType $actionType */
        $actionType = $actionContext->getActionType();
        if ($actionType->equals(ActionType::MOVE())) {
            $edge = $this->tile->getEdge($actionContext->getContext()[0]);
            $edge->getFromTile()->removeUnit($this);
            $edge->getToTile()->addUnit($this);
        }

        return new ActionResult($this, ActionStatus::COMPLETE());
    }

    public function getTile(): Tile
    {
        return $this->tile;
    }

    public function setTile(Tile $tile): void
    {
        $this->tile = $tile;
    }
}
