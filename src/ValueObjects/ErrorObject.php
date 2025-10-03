<?php

namespace DevMurean\EloquentJsonApiSpec\ValueObjects;

use Exception;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class ErrorObject
{
    public static function from(
        Throwable|Exception|HttpException $e,
        null|array|string $message = null
    ): array {
        $status = method_exists($e, 'getStatusCode')
            ? $e->getStatusCode()
            : $e->getCode();

        return [
            'status' => (string) $status,
            'title' => Str::of(class_basename($e))->snake(' ')->apa()->toString(),
            'detail' => $message !== null ? $message : $e->getMessage(),
        ];
    }
}
