<?php
declare(strict_types=1);

namespace TileLand\Player\Action;

use TileLand\Enum\ActionType;
use TileLand\Player\ActionContext\CommandActionContext;

class UnitAction implements Action
{
    use ActionCreatorTrait;

    /**
     * @var ActionType
     */
    protected $actionType;

    /**
     * @var array
     */
    protected $args;

    public function __construct(ActionCreator $actionCreator, ActionType $actionType, ...$args)
    {
        $this->actionCreator = $actionCreator;
        $this->actionType = $actionType;
        $this->args = $args;
    }

    public function consume(): ActionResult
    {
        return $this->actionCreator->performAction($this, new CommandActionContext($this->actionType, ...$this->args));
    }
}

