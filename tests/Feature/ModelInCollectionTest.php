<?php

use DevMurean\EloquentJsonApiSpec\CollectionResource;
use DevMurean\EloquentJsonApiSpec\Tests\Factories\DummyModelFactory;
use DevMurean\EloquentJsonApiSpec\Tests\Factories\DummyRelationshipFactory;
use DevMurean\EloquentJsonApiSpec\Tests\Models\DummyModel;
use Illuminate\Support\Arr;

test('collection of models is handled correctly', function () {
    $desiredModelCount = 2;
    $models = new DummyModelFactory()->count($desiredModelCount)->createQuietly();
    $result = new CollectionResource($models)->get();

    expect(count(Arr::get($result, 'data')))->toBe($desiredModelCount);
});

test('each model in collection has separate relationships attributes', function () {
    $desiredModelCount = 2;
    $models = new DummyModelFactory()
        ->count($desiredModelCount)
        ->createQuietly();

    $models->each(function (DummyModel $dm) {
        $dm->loadMissing('related_model');
    });
    $result = new CollectionResource($models)->get();
    dd($result);

    expect(
        Arr::get($result, 'data.0.relationships.related_model.data.id') !==
            Arr::get($result, 'data.1.relationships.related_model.data.id')
    )->toBeTrue();
});
