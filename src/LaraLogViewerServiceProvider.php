<?php

declare(strict_types=1);

namespace Webmonks\LaraLogViewer;

use Webmonks\Support\Providers\PackageServiceProvider;

/**
 * Class     LaraLogViewerServiceProvider
 *
 * @author   Darshan Baraiya <webmonks.in@gmail.com>
 */
class LaraLogViewerServiceProvider extends PackageServiceProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'laravel-log-viewer';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        parent::register();

        $this->registerConfig();

        $this->registerProvider(Providers\RouteServiceProvider::class);

        $this->registerCommands([
            Commands\PublishCommand::class,
            Commands\StatsCommand::class,
            Commands\CheckCommand::class,
            Commands\ClearCommand::class,
        ]);
    }

    /**
     * Boot the service provider.
     */
    public function boot(): void
    {
        $this->loadTranslations();
        $this->loadViews();

        if ($this->app->runningInConsole()) {
            $this->publishConfig();
            $this->publishTranslations();
            $this->publishViews();
        }
    }
}
