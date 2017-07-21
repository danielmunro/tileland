<?php
declare(strict_types=1);

namespace TileLand\Unit;

use TileLand\Entity\Unit;

class Attack
{
    /**
     * @var Unit
     */
    protected $attacker;

    /**
     * @var Unit
     */
    protected $attacked;

    /**
     * @var bool
     */
    protected $isAttackedUnitAlive;

    /**
     * @var int
     */
    protected $damage;

    public function __construct(Unit $attacker, Unit $attacked, int $damage)
    {
        $this->attacker = $attacker;
        $this->attacked = $attacked;
        $this->isAttackedUnitAlive = $this->attacked->getHp() >= 0;
        $this->damage = $damage;
    }

    public function isAttackedUnitAlive(): bool
    {
        return $this->isAttackedUnitAlive;
    }

    public function getDamage(): int
    {
        return $this->damage;
    }
}
