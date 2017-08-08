<?php
declare(strict_types=1);

namespace TileLand\Silex\ControllerProvider;

use Doctrine\ORM\EntityManager;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use TileLand\Entity\Game;
use TileLand\Entity\Player;
use TileLand\Silex\Controller\GameController;

class GameControllerProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
    }
}
