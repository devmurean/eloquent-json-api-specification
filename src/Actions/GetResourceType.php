<?php

namespace DevMurean\EloquentJsonApiSpec\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GetResourceType
{
    public static function execute(Model $model): string
    {
        if (method_exists($model, 'getResourceTypeName')) {
            return $model->getResourceTypeName();
        }

        return Str::of(class_basename($model))
            ->snake()
            ->plural()
            ->toString();
    }
}
