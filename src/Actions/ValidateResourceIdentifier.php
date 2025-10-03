<?php

namespace DevMurean\EloquentJsonApiSpec\Actions;

use DevMurean\EloquentJsonApiSpec\Exceptions\InvalidResourceIdentifierException;
use Illuminate\Database\Eloquent\Model;

class ValidateResourceIdentifier
{
    public static function execute(?string $intended, Model $resource): void
    {
        throw_if(
            $intended === null ||
                ($resource->id !== null && $resource->id !== $intended),
            new InvalidResourceIdentifierException
        );
    }
}
