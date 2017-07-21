<?php
declare(strict_types=1);

namespace TileLand\Player\Action;

use TileLand\Player\ActionContext\ActionContext;
use TileLand\Player\Action\ActionResult;

interface ActionCreator
{
    public function performAction(Action $action, ActionContext $actionContext): ActionResult;
}
