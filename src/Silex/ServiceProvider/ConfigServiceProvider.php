<?php
declare(strict_types=1);

namespace TileLand\Silex\ServiceProvider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConfigServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['config'] = \Symfony\Component\Yaml\Yaml::parse(
            <<<NOCONFIG
debug: true
persist:
  driver: pdo_mysql
  dbname: tileland
  user: root
  password: ""
  host: localhost
NOCONFIG
        );
    }
}
