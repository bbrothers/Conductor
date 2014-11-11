<?php namespace Conductor\Decorators;

use Conductor\Contracts\Conductor;
use Conductor\Contracts\Request;
use Conductor\Contracts\Resolver;
use Conductor\Inflector;
use Psr\Log\LoggerInterface as Logger;
use ReflectionException;

/**
 * Class LoggingBus
 * @package Conductor\Decorators
 */
class LoggingBus implements Conductor
{

    /**
     * @var Conductor
     */
    private $bus;
    /**
     * @var Resolver
     */
    private $resolver;
    /**
     * @var Inflector
     */
    private $inflector;
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param Conductor $bus
     * @param Resolver  $resolver
     * @param Inflector $inflector
     * @param Logger    $logger
     */
    public function __construct(Conductor $bus, Resolver $resolver, Inflector $inflector, Logger $logger)
    {

        $this->bus       = $bus;
        $this->resolver  = $resolver;
        $this->inflector = $inflector;
        $this->logger    = $logger;
    }

    /**
     * @param Request $request
     */
    public function execute(Request $request)
    {

        $this->log($request);
    }

    /**
     * @param Request $request
     */
    public function log(Request $request)
    {

        $loggerClass = $this->inflector->getLoggerClass($request);
        try {
            $logger = $this->resolver->make($loggerClass);
            $logger->log($request);
        } catch (ReflectionException $e) {
            $this->logger->error($e);
        }
    }


}
