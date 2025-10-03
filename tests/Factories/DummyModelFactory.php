<?php

namespace DevMurean\EloquentJsonApiSpec\Tests\Factories;

use DevMurean\EloquentJsonApiSpec\Tests\Models\DummyModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class DummyModelFactory extends Factory
{
    protected $model = DummyModel::class;

    public function definition(): array
    {
        return [
            'name' => (string) rand(1, 1000),
            'relationship_id' => new DummyRelationshipFactory()
        ];
    }
}
