<?php
declare(strict_types=1);

namespace TileLand\Player\Action;

use TileLand\Player\Action\ActionResult;

interface Action
{
    public function getActionCreator(): ActionCreator;

    public function consume(): ActionResult;
}
