<?php

namespace DevMurean\EloquentJsonApiSpec;

use DevMurean\EloquentJsonApiSpec\Actions\GetDataFromModel;
use DevMurean\EloquentJsonApiSpec\Actions\GetIncludedFromModel;
use DevMurean\EloquentJsonApiSpec\Actions\GetRelationshipFromModel;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ModelResource implements Responsable
{
    public function __construct(private Model $model) {}

    public function get(): array
    {
        return [
            'data' => GetDataFromModel::execute($this->model),
            'relationships' => GetRelationshipFromModel::execute($this->model),
            'included' => GetIncludedFromModel::execute($this->model),
        ];
    }

    public function toResponse($request = null): JsonResponse
    {
        $result = $this->get();

        return response()
            ->json($result, $this->getHttpResponseCode());
    }

    private function getHttpResponseCode(): int
    {
        return $this->model->wasRecentlyCreated
            ? Response::HTTP_CREATED
            : Response::HTTP_OK;
    }
}
