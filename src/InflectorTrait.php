<?php namespace Conductor;

use Conductor\Exceptions\HandlerNotFoundException;

trait InflectorTrait {

    public function getHandlerClass($request)
    {
        $handler = $this->inflect('Handler', $request);
        if (class_exists($handler)) {
            return $handler;
        }
        throw new HandlerNotFoundException;
    }

    protected function inflect($type, $request)
    {
        return str_replace('Request', $type, get_class($request));
    }
}
