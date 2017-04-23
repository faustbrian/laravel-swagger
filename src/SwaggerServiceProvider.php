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

use BrianFaust\ServiceProvider\AbstractServiceProvider;

class SwaggerServiceProvider extends AbstractServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot(): void
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
    public function register(): void
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
    protected function getPackageName(): string
    {
        return 'laravel-swagger';
    }
}
