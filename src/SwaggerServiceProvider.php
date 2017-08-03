<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Swagger.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Swagger;

use Illuminate\Support\ServiceProvider;

class SwaggerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-swagger.php' => config_path('laravel-swagger.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/laravel-swagger'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../public/assets' => public_path('vendor/laravel-swagger'),
        ], 'public');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-swagger');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-swagger.php', 'laravel-swagger');

        $this->commands(Console\Commands\GenerateDocsCommand::class);
    }
}
