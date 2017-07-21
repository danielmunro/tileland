<?php
declare(strict_types=1);

namespace TileLand\Player\Action;

use TileLand\Enum\ActionStatus;

class ActionResult
{
    protected $actionCreator;

    protected $actionStatus;

    public function __construct(ActionCreator $actionCreator, ActionStatus $actionStatus)
    {
        $this->actionCreator = $actionCreator;
        $this->actionStatus = $actionStatus;
    }

    public function getActionCreator(): ActionCreator
    {
        return $this->actionCreator;
    }

    public function getActionStatus(): ActionStatus
    {
        return $this->actionStatus;
    }
}
