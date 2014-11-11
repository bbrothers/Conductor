<?php namespace Conductor\Exceptions;

use Exception;

class ConductorNotImplementedException extends Exception
{

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {

        if (empty($message)) {
            $message = 'Decorators must implement the Conductor interface.';
        }

        parent::__construct($message, $code, $previous);
    }
}
