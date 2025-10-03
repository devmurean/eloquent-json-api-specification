<?php

namespace DevMurean\EloquentJsonApiSpec\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DummyModel extends Model
{
    protected $table = 'models';

    public function related_model(): BelongsTo
    {
        return $this->belongsTo(DummyRelationship::class, 'relationship_id');
    }
}
