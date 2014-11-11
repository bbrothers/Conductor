<?php namespace Conductor;


abstract class Response
{

    private $data;

    protected function __construct($data = null)
    {

        $this->data = $data;
    }

    public static function void()
    {

        return new static;
    }

    public static function create($data)
    {

        return new static($data);
    }

    public function getData()
    {

        return $this->data;
    }
}
