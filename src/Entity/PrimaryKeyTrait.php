<?php
declare(strict_types=1);

namespace TileLand\Entity;

trait PrimaryKeyTrait
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}