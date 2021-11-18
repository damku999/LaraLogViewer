<?php

declare(strict_types=1);

namespace Webmonks\LaraLogViewer\Providers;

use Webmonks\LaraLogViewer\Contracts\LaraLogViewer as LaraLogViewerContract;
use Webmonks\LaraLogViewer\Contracts\Utilities\Factory as FactoryContract;
use Webmonks\LaraLogViewer\Contracts\Utilities\Filesystem as FilesystemContract;
use Webmonks\LaraLogViewer\Contracts\Utilities\LogChecker as LogCheckerContract;
use Webmonks\LaraLogViewer\Contracts\Utilities\LogLevels as LogLevelsContract;
use Webmonks\LaraLogViewer\Contracts\Utilities\LogMenu as LogMenuContract;
use Webmonks\LaraLogViewer\Contracts\Utilities\LogStyler as LogStylerContract;
use Webmonks\LaraLogViewer\LaraLogViewer;
use Webmonks\LaraLogViewer\Utilities;
use Webmonks\Support\Providers\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

/**
 * Class     DeferredServicesProvider
 *
 * @author   Darshan Baraiya <webmonks.in@gmail.com>
 */
class DeferredServicesProvider extends ServiceProvider implements DeferrableProvider
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->registerLaraLogViewer();
        $this->registerLogLevels();
        $this->registerStyler();
        $this->registerLogMenu();
        $this->registerFilesystem();
        $this->registerFactory();
        $this->registerChecker();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            LaraLogViewerContract::class,
            LogLevelsContract::class,
            LogStylerContract::class,
            LogMenuContract::class,
            FilesystemContract::class,
            FactoryContract::class,
            LogCheckerContract::class,
        ];
    }

    /* -----------------------------------------------------------------
     |  LaraLogViewer Utilities
     | -----------------------------------------------------------------
     */

    /**
     * Register the log viewer service.
     */
    private function registerLaraLogViewer(): void
    {
        $this->singleton(LaraLogViewerContract::class, LaraLogViewer::class);
    }

    /**
     * Register the log levels.
     */
    private function registerLogLevels(): void
    {
        $this->singleton(LogLevelsContract::class, function ($app) {
            return new Utilities\LogLevels(
                $app['translator'],
                $app['config']->get('laravel-log-viewer.locale')
            );
        });
    }

    /**
     * Register the log styler.
     */
    private function registerStyler(): void
    {
        $this->singleton(LogStylerContract::class, Utilities\LogStyler::class);
    }

    /**
     * Register the log menu builder.
     */
    private function registerLogMenu(): void
    {
        $this->singleton(LogMenuContract::class, Utilities\LogMenu::class);
    }

    /**
     * Register the log filesystem.
     */
    private function registerFilesystem(): void
    {
        $this->singleton(FilesystemContract::class, function ($app) {
            /** @var  \Illuminate\Config\Repository  $config */
            $config     = $app['config'];
            $filesystem = new Utilities\Filesystem($app['files'], $config->get('laravel-log-viewer.storage-path'));

            return $filesystem->setPattern(
                $config->get('laravel-log-viewer.pattern.prefix', FilesystemContract::PATTERN_PREFIX),
                $config->get('laravel-log-viewer.pattern.date', FilesystemContract::PATTERN_DATE),
                $config->get('laravel-log-viewer.pattern.extension', FilesystemContract::PATTERN_EXTENSION)
            );
        });
    }

    /**
     * Register the log factory class.
     */
    private function registerFactory(): void
    {
        $this->singleton(FactoryContract::class, Utilities\Factory::class);
    }

    /**
     * Register the log checker service.
     */
    private function registerChecker(): void
    {
        $this->singleton(LogCheckerContract::class, Utilities\LogChecker::class);
    }
}
