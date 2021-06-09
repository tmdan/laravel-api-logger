<?php

namespace Tmdan\ApiLogger\Providers;

use Tmdan\ApiLogger\Console\Commands\ApiLoggerClear;
use Illuminate\Support\ServiceProvider;
use Tmdan\ApiLogger\Middleware\ApiLoggerMiddleware;

class ApiLoggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigration();
        $this->loadCommands();
        $this->loadMiddleware();
        $this->loadPublishableResources();
    }

    public function register()
    {
        $this->registerConfig();
    }

    public function loadPublishableResources()
    {
        $publishablePath = __DIR__ . '/../../publishable';

        $publishable = [
            'migrations' => [
                "{$publishablePath}/database/migrations/" => database_path('migrations'),
            ],
            'config' => [
                "{$publishablePath}/config/api-logger.php" => config_path('api-logger.php'),
            ],

        ];

        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }

    public function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../publishable/config/api-logger.php',
            'api-logger'
        );
    }

    public function loadMiddleware()
    {
        $this->aliasMiddleware('api.logger', ApiLoggerMiddleware::class);
    }

    public function loadCommands()
    {
        $this->commands(ApiLoggerClear::class);
    }

    public function loadMigration()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../publishable/database/migrations');
    }
}
