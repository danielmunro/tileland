<?php
declare(strict_types=1);

namespace TileLand\Player\Action;

use TileLand\City\Producible;
use TileLand\Player\ActionContext\ProducibleActionContext;

class CityAction implements Action
{
    use ActionCreatorTrait;

    /**
     * @var Producible
     */
    protected $producible;

    public function __construct(ActionCreator $actionCreator, Producible $producible)
    {
        $this->actionCreator = $actionCreator;
        $this->producible = $producible;
    }

    public function consume(): ActionResult
    {
        return $this->actionCreator->performAction($this, new ProducibleActionContext($this->producible));
    }
}
