<?php

namespace DevMurean\EloquentJsonApiSpec;

use DevMurean\EloquentJsonApiSpec\Actions\GetDataFromModel;
use DevMurean\EloquentJsonApiSpec\Actions\GetIncludedFromModel;
use DevMurean\EloquentJsonApiSpec\Actions\GetRelationshipFromModel;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class LengthAwarePaginatorResource implements Responsable
{
    public function __construct(private LengthAwarePaginator $lap) {}

    public function get(): array
    {
        $data = [];
        $included = [];

        /** @var array<int,Model> $items */
        $items = $this->lap->items();
        foreach ($items as $model) {
            $data[] = array_merge(
                GetDataFromModel::execute($model),
                ['relationships' => GetRelationshipFromModel::execute($model)]
            );

            $included = array_merge(
                $included,
                GetIncludedFromModel::execute($model)
            );
        }

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
            'links' => [
                'path' => $this->lap->path(),
                'prev_page_url' => $this->lap->previousPageUrl(),
                'next_page_url' => $this->lap->nextPageUrl(),
                'first_page_url' => $this->lap->url(1),
                'last_page_url' => $this->lap->url($this->lap->lastPage()),
            ],
            'pagination' => [
                'current_page' => $this->lap->currentPage(),
                'total' => $this->lap->total(),
                'per_page' => $this->lap->perPage(),
            ],
        ];
    }

    public function toResponse($request = null): JsonResponse
    {
        $result = $this->get();

        return response()
            ->json($result, 200);
    }
}
