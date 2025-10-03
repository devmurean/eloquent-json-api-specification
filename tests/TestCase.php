<?php

namespace DevMurean\EloquentJsonApiSpec\Tests;

use Orchestra\Testbench\Attributes\WithEnv;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

#[WithEnv('DB_CONNECTION', 'testing')]
class TestCase extends TestbenchTestCase
{
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(
            __DIR__ . '/Migrations'
        );
    }
}
