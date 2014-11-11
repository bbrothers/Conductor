<?php namespace Conductor;

use Conductor\Contracts\NameInflector;
use Conductor\Exceptions\InflectorNotFoundException;

class Inflector implements NameInflector
{

    use InflectorTrait;

    public function __call($method, $params)
    {

        preg_match('/get(.+)Class/', $method, $match);

        if (empty($match[1])) {
            throw new InflectorNotFoundException;
        }

        return $this->inflect($match[1], $params[0]);

    }

}
