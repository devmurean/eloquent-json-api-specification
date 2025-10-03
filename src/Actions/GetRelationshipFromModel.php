<?php

namespace DevMurean\EloquentJsonApiSpec\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Get relationship and extract the model into included
 */
class GetRelationshipFromModel
{
    public static function execute(Model $model): array
    {
        /** @var array<string, Model|Collection> $relations */
        $relations = $model->getRelations();
        $relationships = [];

        foreach ($relations as $name => $related) {
            if ($related instanceof Model) {
                $relationships[$name]['data'] = self::build($related);
            }

            if ($related instanceof Collection) {
                $relationships[$name]['data'] = $related->map(
                    function (Model $item) {
                        return self::build($item);
                    }
                )
                    ->toArray();
            }
        }

        return $relationships;
    }

    protected static function build(Model $related): array
    {
        return [
            'id' => $related->getKey(),
            'type' => GetResourceType::execute($related),
        ];
    }
}
