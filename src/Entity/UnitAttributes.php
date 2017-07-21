<?php
declare(strict_types=1);

namespace TileLand\Entity;

use DiceCalc\Calc;

/**
 * @Entity
 */
class UnitAttributes
{
    use PrimaryKeyTrait;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $hp;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $maxHp;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $mv;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $maxMv;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $damageDice;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $armorClass;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $range;

    public function __construct(
        int $maxHp,
        int $maxMv,
        int $armorClass,
        int $range,
        string $damageDice
    ) {
        $this->hp = $maxHp;
        $this->maxHp = $maxHp;
        $this->mv = $maxMv;
        $this->maxMv = $maxMv;
        $this->armorClass = $armorClass;
        $this->range = $range;
        $this->damageDice = $damageDice;
    }

    public function getHp(): int
    {
        return $this->hp;
    }

    public function getMaxHp(): int
    {
        return $this->maxHp;
    }

    public function getDamageRoll(): int
    {
        return (new Calc($this->damageDice))();
    }

    public function getArmorClass(): int
    {
        return $this->armorClass;
    }

    public function receiveDamage(int $damage): void
    {
        $this->hp -= $damage;
    }

    public function regenHp(int $hp = 1): void
    {
        $this->hp += $hp;

        if ($this->hp > $this->maxHp) {
            $this->hp = $this->maxHp;
        }
    }

    public function regenMv(): void
    {
        $this->mv = $this->maxMv;
    }

    public function consumeMovement(): void
    {
        $this->mv--;
    }

    public function getMv(): int
    {
        return $this->mv;
    }

    public function getMaxMv(): int
    {
        return $this->maxMv;
    }
}
