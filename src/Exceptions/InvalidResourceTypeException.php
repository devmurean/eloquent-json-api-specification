<?php

namespace DevMurean\EloquentJsonApiSpec\Exceptions;

use Exception;
use Throwable;

class InvalidResourceTypeException extends Exception
{
    public function __construct($message = null, $code = null, ?Throwable $previous = null)
    {
        parent::__construct($message ?? 'Resource Type is Invalid for the request', 400, $previous);

        $this->code = $code ?: 400;
    }
}
