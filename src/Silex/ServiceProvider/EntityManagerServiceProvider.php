<?php
declare(strict_types=1);

namespace TileLand\Silex\ServiceProvider;

use Doctrine\ORM\EntityManager;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class EntityManagerServiceProvider implements ServiceProviderInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function register(Container $pimple)
    {
        $pimple['em'] = $this->em;
    }
}
