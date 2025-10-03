<?php

namespace DevMurean\EloquentJsonApiSpec\Exceptions;

use Exception;
use Throwable;

class InvalidResourceIdentifierException extends Exception
{
    public function __construct($message = null, $code = null, ?Throwable $previous = null)
    {
        parent::__construct(
            $message ?? 'Resource Identifier is Invalid or must no be null for the request',
            400,
            $previous
        );
    }
}
