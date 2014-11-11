<?php namespace Conductor\Laravel;

use Conductor\Laravel\Exceptions\ValidationException;
use Illuminate\Support\Contracts\ArrayableInterface;
use Illuminate\Validation\Factory as Validator;

abstract class RequestValidator
{

    public $validator;

    public function __construct(Validator $validator)
    {

        $this->validator = $validator;
    }

    public function validate($request)
    {

        $validator = $this->validator->make($this->extractData($request), $this->rules);

        if ($validator->fails()) {
            $this->onFail($validator, $request);
        }
    }

    abstract function extractData($request);


    public function onFail($validator)
    {

        throw new ValidationException($validator->messages());
    }
}
