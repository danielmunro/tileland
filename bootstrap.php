<?php

require_once __DIR__.'/vendor/autoload.php';

$config = \Symfony\Component\Yaml\Yaml::parse(<<<NOCONFIG
debug: true
persist:
  driver: pdo_sqlite
  path: db.sqlite
NOCONFIG
);

$em = \Doctrine\ORM\EntityManager::create(
    $config['persist'],
    \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
        [
            __DIR__.'/src/Entity'
        ],
        $config['debug']
    )
);
