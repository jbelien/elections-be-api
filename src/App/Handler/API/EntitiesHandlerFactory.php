<?php

declare (strict_types = 1);

namespace App\Handler\API;

use App\Cache;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EntitiesHandlerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        $config = $container->get('config');

        $cache = $config[Cache::ENABLE_CACHE] ?? false;

        return new EntitiesHandler($cache);
    }
}
