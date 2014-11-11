<?php namespace Conductor;

use Conductor\Contracts\Conductor;
use Conductor\Contracts\NameInflector;
use Conductor\Contracts\Request;
use Conductor\Exceptions\ConductorNotImplementedException;
use Conductor\Contracts\Resolver;
use Psr\Log\LoggerInterface as Logger;

class ExecutionBus implements Conductor
{

    private $decorators;

    private $resolver;

    private $inflector;

    private $log;

    public function __construct(Resolver $resolver, NameInflector $inflector, Logger $log)
    {

        $this->resolver  = $resolver;
        $this->inflector = $inflector;
        $this->log       = $log;
    }

    public function execute(Request $request)
    {

        $this->decorate('Conductor\Decorators\Validation');

        $this->executeDecorators($request);

        return $this->getHandler($request)->handle($request);
    }

    public function getHandler(Request $request)
    {

        return $this->resolver->resolve($this->inflector->getHandlerClass($request));
    }

    public function decorate($className)
    {

        $this->decorators[] = $className;
        return $this;
    }

    protected function executeDecorators(Request $request)
    {

        foreach ($this->decorators as $className) {

            if ( ! class_exists($className)) {
                $this->log->debug(sprintf('Decorator class "%s" not found.', $className));
                continue;
            }

            $instance = $this->resolver->resolve($className);

            if ( ! $instance instanceof Conductor) {
                throw new ConductorNotImplementedException;
            }

            $instance->execute($request);
        }
    }
}
