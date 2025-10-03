<?php

use DevMurean\EloquentJsonApiSpec\LengthAwarePaginatorResource;
use DevMurean\EloquentJsonApiSpec\Tests\Factories\DummyModelFactory;
use DevMurean\EloquentJsonApiSpec\Tests\Models\DummyModel;
use Illuminate\Support\Arr;

test('pagination is formatted correctly', function () {
    new DummyModelFactory()->count(3)
        ->createQuietly();

    $models = DummyModel::query()->paginate();

    $result = new LengthAwarePaginatorResource($models)->get();

    expect(Arr::get($result, 'pagination.total'))->toBe(3);
});
