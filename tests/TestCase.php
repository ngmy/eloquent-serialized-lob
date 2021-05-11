<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Tests;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Ngmy\EloquentSerializedLob\EloquentSerializedLobServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array<int, string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            IdeHelperServiceProvider::class,
            EloquentSerializedLobServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app->make('config')->set('database.default', 'mysql');
    }
}
