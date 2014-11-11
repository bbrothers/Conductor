<?php namespace Conductor\Laravel;

use Conductor\Contracts\Resolver;
use Illuminate\Container\Container;

class ConductorResolver implements Resolver
{

    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function resolve($className, $params = [])
    {
        return $this->container->make($className, $params);
    }
}
