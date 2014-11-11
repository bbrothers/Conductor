<?php namespace Conductor\Contracts;

interface Resolver {

    public function resolve($className, $params = []);

}
