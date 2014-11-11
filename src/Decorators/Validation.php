<?php namespace Conductor\Decorators;

use Conductor\Contracts\Conductor;
use Conductor\Contracts\NameInflector;
use Conductor\Contracts\Request;
use Conductor\Contracts\Resolver;
use Psr\Log\LoggerInterface as Logger;

/**
 * Class Validation
 * @package Conductor
 */
class Validation implements Conductor
{

    /**
     * @var \Conductor\Contracts\Resolver
     */
    private $resolver;
    /**
     * @var \Conductor\Inflector
     */
    private $inflector;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $log;

    /**
     * @param \Conductor\Contracts\Resolver      $resolver
     * @param \Conductor\Contracts\NameInflector $inflector
     * @param \Psr\Log\LoggerInterface           $log
     */
    public function __construct(Resolver $resolver, NameInflector $inflector, Logger $log)
    {

        $this->resolver  = $resolver;
        $this->inflector = $inflector;
        $this->log       = $log;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function execute(Request $request)
    {

        return $this->validate($request);
    }

    /**
     * @param Request $request
     * @return mixed|null
     */
    public function validate(Request $request)
    {

        $validatorClass = $this->inflector->getValidatorClass($request);
        if (class_exists($validatorClass)) {
            return $this->resolver->resolve($validatorClass)->validate($request);
        }
        $this->log->debug(sprintf('Validator for "%s" not found.', $validatorClass));
        return null;
    }

}
