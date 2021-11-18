<?php

declare (strict_types = 1);

namespace Webmonks\LaraLogViewer\Http\Routes;

use Webmonks\LaraLogViewer\Http\Controllers\LaraLogViewerController;
use Webmonks\Support\Routing\RouteRegistrar;

/**
 * Class     LaraLogViewerRoute
 *
 * @author   Darshan Baraiya <webmonks.in@gmail.com>
 */
class LaraLogViewerRoute extends RouteRegistrar
{
    /* -----------------------------------------------------------------
    |  Main Methods
    | -----------------------------------------------------------------
     */

    /**
     * Map all routes.
     */
    public function map(): void
    {
        $attributes = (array) config('laravel-log-viewer.route.attributes');

        $this->group($attributes, function () {
            $this->name('laravel-log-viewer::')->group(function () {
                $this->get('/', [LaraLogViewerController::class, 'index'])
                    ->name('dashboard'); // laravel-log-viewer::dashboard

                $this->mapLogsRoutes();
            });
        });
    }

    /**
     * Map the logs routes.
     */
    private function mapLogsRoutes(): void
    {
        $this->prefix('logs')->name('logs.')->group(function () {
            $this->get('/', [LaraLogViewerController::class, 'listLogs'])
                ->name('list'); // laravel-log-viewer::logs.list

            $this->delete('delete', [LaraLogViewerController::class, 'delete'])
                ->name('delete'); // laravel-log-viewer::logs.delete

            $this->prefix('{date}')->group(function () {
                $this->get('/', [LaraLogViewerController::class, 'show'])
                    ->name('show'); // laravel-log-viewer::logs.show

                $this->get('download', [LaraLogViewerController::class, 'download'])
                    ->name('download'); // laravel-log-viewer::logs.download

                $this->get('{level}', [LaraLogViewerController::class, 'showByLevel'])
                    ->name('filter'); // laravel-log-viewer::logs.filter

                $this->get('{level}/search', [LaraLogViewerController::class, 'search'])
                    ->name('search'); // laravel-log-viewer::logs.search
            });
        });
    }
}
