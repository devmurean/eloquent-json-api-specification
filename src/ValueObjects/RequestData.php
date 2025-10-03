<?php

namespace DevMurean\EloquentJsonApiSpec\ValueObjects;

/**
 * Automatically fetch data parameter from request
 */
class RequestData
{
    public string $type;

    public ?string $id = null;

    public array $attributes;

    public array $included = [];

    public function __construct(array $data)
    {
        $this->included = $data['included'] ?? [];

        $data = $data['data'] ?? $data;
        $this->type = $data['type'];
        $this->id = $data['id'];
        $this->attributes = $data['attributes'];
    }

    public function searchInIncluded(string $type): ?RequestData
    {
        $collection = collect($this->included);
        $result = $collection->where('type', '=', $type)->first();
        if (! $result) {
            return null;
        }

        return new RequestData($result);
    }
}
