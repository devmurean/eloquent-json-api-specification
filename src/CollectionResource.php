<?php

namespace DevMurean\EloquentJsonApiSpec;

use DevMurean\EloquentJsonApiSpec\Actions\GetDataFromModel;
use DevMurean\EloquentJsonApiSpec\Actions\GetIncludedFromModel;
use DevMurean\EloquentJsonApiSpec\Actions\GetRelationshipFromModel;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class CollectionResource implements Responsable
{
    public function __construct(private Collection $collection) {}

    public function get(): array
    {
        $data = [];
        $included = [];

        $this
            ->collection
            ->each(function (Model $model) use (&$included, &$data) {
                $data[] = array_merge(
                    GetDataFromModel::execute($model),
                    ['relationships' => GetRelationshipFromModel::execute($model)]
                );

                $included = array_merge(
                    $included,
                    GetIncludedFromModel::execute($model)
                );
            });

        $included = collect($included)
            ->unique(function (array $item) {
                return $item['type'] . $item['id'];
            })
            ->sortBy('type')
            ->values()
            ->all();

        return [
            'data' => $data,
            'included' => $included,
        ];
    }

    public function toResponse($request = null): JsonResponse
    {
        $result = $this->get();

        return response()
            ->json($result, 200);
    }
}
