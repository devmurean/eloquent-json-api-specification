<?php

namespace DevMurean\EloquentJsonApiSpec\Actions;

use Illuminate\Database\Eloquent\Model;

class GetDataFromModel
{
    public static function execute(Model $model): array
    {
        $data = [
            'type' => GetResourceType::execute($model),
            'id' => $model->getKey(),
            'attributes' => $model->withoutRelations()->toArray(),
        ];

        // remove id from attributes since it's already declared in id
        unset($data['attributes']['id']);

        return $data;
    }
}
