<?php

/*
 * This file is part of Laravel Swagger.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Swagger;

use BrianFaust\ServiceProvider\ServiceProvider;

class SwaggerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishConfig();
        $this->publishViews();
        $this->publishAssets();

        $this->loadViews();
        $this->loadRoutes();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        parent::register();

        $this->mergeConfig();

        $this->commands(Console\GenerateDocsCommand::class);
    }

    /**
     * Get the default package name.
     *
     * @return string
     */
    protected function getPackageName()
    {
        return 'laravel-swagger';
    }
}
