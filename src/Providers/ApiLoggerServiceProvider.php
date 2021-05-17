<?php

namespace Tmdan\ApiLogger\Providers;

use App\Console\Commands\ApiLoggerClear;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Tmdan\ApiLogger\Middleware\ApiLoggerMiddleware;

class ApiLoggerServiceProvider extends ServiceProvider
{
    public function boot(Router $router)
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../publishable/database/migrations');

        $router->aliasMiddleware('api.logger', ApiLoggerMiddleware::class);
    }


    public function register()
    {
        $this->registerConfigs();
        $this->registerPublishableResources();
        $this->registerConsoleCommands();
    }

    private function registerConsoleCommands()
    {
        $this->commands(ApiLoggerClear::class);
    }

    private function registerConfigs()
    {
        $this->mergeConfigFrom(
            __DIR__. '/../../publishable/config/api-logger.php',
            'api-logger'
        );
    }

    private function registerPublishableResources()
    {
        $publishablePath = __DIR__.'/../../publishable';

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

}
