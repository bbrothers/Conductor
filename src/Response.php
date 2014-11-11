<?php namespace Conductor;


abstract class Response
{

    private $payload;

    public function __construct($payload = null)
    {

        $this->payload = $payload;
    }

    public function __invoke()
    {
        return $this->payload;
    }

}
