<?php

namespace DevMurean\EloquentJsonApiSpec\Tests\Factories;

use DevMurean\EloquentJsonApiSpec\Tests\Models\DummyRelationship;
use Illuminate\Database\Eloquent\Factories\Factory;

class DummyRelationshipFactory extends Factory
{
    protected $model = DummyRelationship::class;

    public function definition(): array
    {
        return [
            'name' => (string) rand(1000, 10000),
        ];
    }
}
