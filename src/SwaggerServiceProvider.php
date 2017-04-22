<?php



declare(strict_types=1);



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
