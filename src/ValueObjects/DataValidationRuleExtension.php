<?php

namespace DevMurean\EloquentJsonApiSpec\ValueObjects;

class DataValidationRuleExtension
{
    public static function from(array $rules): array
    {
        $result = [
            'data' => ['required', 'array:type,id,attributes'],
            'data.type' => ['required', 'string'],
            'data.id' => ['nullable', 'string'],
            'included' => ['sometimes'],
        ];
        $keys = implode(',', array_keys($rules));

        $result['data.attributes'] = 'array:' . $keys;

        foreach ($rules as $key => $rule) {
            $result['data.attributes.' . $key] = $rule;
        }

        return $result;
    }
}
