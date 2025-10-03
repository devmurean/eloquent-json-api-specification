<?php

use DevMurean\EloquentJsonApiSpec\ModelResource;
use DevMurean\EloquentJsonApiSpec\Tests\Factories\DummyModelFactory;
use DevMurean\EloquentJsonApiSpec\Tests\Factories\DummyRelationshipFactory;
use Illuminate\Support\Arr;

test('Single Eloquent model is formatted correctly', function () {
    $model = new DummyModelFactory()->createQuietly();

    $result = new ModelResource($model)->get();

    expect(Arr::has($result, [
        'data',
        'data.type',
        'data.attributes',
        'data.attributes.name',
        'data.attributes.relationship_id',
        'relationships',
        'included'
    ]))->toBeTrue();
});

test('data.type is based on models name or defined inside related model', function () {
    $model = new DummyModelFactory()->createQuietly();
    $result = new ModelResource($model)->get();
    expect($result['data']['type'])->toBe('dummy_models');

    $model = new DummyRelationshipFactory()->createQuietly();
    $result = new ModelResource($model)->get();
    expect($result['data']['type'])->toBe('real_relationships');
});

test('when model has loaded relationships it will be included automatically', function () {
    $model = new DummyModelFactory()->createQuietly();
    $model->loadMissing('related_model');
    $result = new ModelResource($model)->get();

    expect(Arr::has($result, [
        'relationships.related_model.data.id',
        'relationships.related_model.data.type',
        'included.0.type',
        'included.0.id',
        'included.0.attributes',
        'included.0.attributes.name',
        'included.0.relationships',
    ]))->toBeTrue();

    expect(Arr::get($result, 'relationships.related_model.data.id'))->toBe($model->related_model->id);
});
