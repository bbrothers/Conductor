<?php namespace Conductor\Laravel\Exceptions;

use Exception;
use Illuminate\Support\MessageBag;

class ValidationException extends Exception
{

    public function __construct($messages, $code = 0, Exception $previous = null)
    {

        if ( ! $messages instanceof MessageBag) {
            $messages = new MessageBag((array) $messages);
        }
        $this->messages = $messages;

        parent::__construct($this->messages->first(), $code, $previous);
    }

    public function getMessages()
    {

        return $this->messages;
    }
}
