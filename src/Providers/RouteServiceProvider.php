<?php

declare(strict_types=1);

namespace Webmonks\LaraLogViewer\Providers;

use Webmonks\LaraLogViewer\Http\Routes\LaraLogViewerRoute;
use Webmonks\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * Class     RouteServiceProvider
 *
 * @author   Darshan Baraiya <webmonks.in@gmail.com>
 */
class RouteServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Check if routes is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return (bool) $this->config('enabled', false);
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Boot the service provider.
     */
    public function boot(): void
    {
        if ($this->isEnabled()) {
            $this->routes(function () {
                static::mapRouteClasses([LaraLogViewerRoute::class]);
            });
        }
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get config value by key
     *
     * @param  string      $key
     * @param  mixed|null  $default
     *
     * @return mixed
     */
    private function config($key, $default = null)
    {
        return $this->app['config']->get("laravel-log-viewer.route.$key", $default);
    }
}
