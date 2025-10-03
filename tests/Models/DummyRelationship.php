<?php

namespace DevMurean\EloquentJsonApiSpec\Tests\Models;

use Illuminate\Database\Eloquent\Model;

class DummyRelationship extends Model
{
    protected $table = 'relationships';

    public function getResourceTypeName(): string
    {
        return 'real_relationships';
    }
}
