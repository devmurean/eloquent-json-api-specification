<?php

namespace DevMurean\EloquentJsonApiSpec\Actions;

use DevMurean\EloquentJsonApiSpec\Exceptions\InvalidResourceTypeException;
use Illuminate\Database\Eloquent\Model;

class ValidateResourceType
{
    public static function execute(string $intended, Model $model): void
    {
        throw_if(
            GetResourceType::execute($model) !== $intended,
            new InvalidResourceTypeException
        );
    }
}
