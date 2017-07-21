<?php
declare(strict_types=1);

namespace TileLand\Player\ActionContext;

use TileLand\Enum\ActionType;

class CommandActionContext implements ActionContext
{
    /**
     * @var ActionType
     */
    protected $actionType;

    /**
     * @var array
     */
    protected $args;

    public function __construct(ActionType $actionType, ...$args)
    {
        $this->actionType = $actionType;
        $this->args = $args;
    }

    public function getActionType(): ActionType
    {
        return $this->actionType;
    }

    public function getContext(): array
    {
        return $this->args;
    }
}
