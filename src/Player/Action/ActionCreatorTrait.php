<?php
declare(strict_types=1);

namespace TileLand\Player\Action;

trait ActionCreatorTrait
{
    /**
     * @var ActionCreator
     */
    protected $actionCreator;

    public function getActionCreator(): ActionCreator
    {
        return $this->actionCreator;
    }
}
