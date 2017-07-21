<?php
declare(strict_types=1);

namespace TileLand\Player\ActionContext;

use TileLand\City\Producible;
use TileLand\Player\ActionContext\ActionContext;

class ProducibleActionContext implements ActionContext
{
    protected $producible;

    public function __construct(Producible $producible)
    {
        $this->producible = $producible;
    }

    /**
     * @return Producible
     */
    public function getContext(): Producible
    {
        return $this->producible;
    }
}
