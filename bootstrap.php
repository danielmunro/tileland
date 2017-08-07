<?php

require_once __DIR__.'/vendor/autoload.php';

use Silex\Application;
use TileLand\Silex\ServiceProvider\ConfigServiceProvider;
use TileLand\Silex\ServiceProvider\EntityManagerServiceProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

$app = new Application();
$app->register(new ConfigServiceProvider());
$config = $app['config'];
$app['debug'] = $config['debug'];
$app->register(
    new EntityManagerServiceProvider(
        EntityManager::create(
            $config['persist'],
            Setup::createAnnotationMetadataConfiguration(
                [
                    __DIR__.'/src/Entity'
                ],
                $config['debug']
            )
        )
    )
);
