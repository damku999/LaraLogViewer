<?php
 
use Webmonks\LaraLogViewer\Contracts;

if ( ! function_exists('log_viewer')) {
    /**
     * Get the LaraLogViewer instance.
     *
     * @return Webmonks\LaraLogViewer\Contracts\LaraLogViewer
     */
    function log_viewer()
    {
        return app(Contracts\LaraLogViewer::class);
    }
}

if ( ! function_exists('log_levels')) {
    /**
     * Get the LogLevels instance.
     *
     * @return Webmonks\LaraLogViewer\Contracts\Utilities\LogLevels
     */
    function log_levels()
    {
        return app(Contracts\Utilities\LogLevels::class);
    }
}

if ( ! function_exists('log_menu')) {
    /**
     * Get the LogMenu instance.
     *
     * @return Webmonks\LaraLogViewer\Contracts\Utilities\LogMenu
     */
    function log_menu()
    {
        return app(Contracts\Utilities\LogMenu::class);
    }
}

if ( ! function_exists('log_styler')) {
    /**
     * Get the LogStyler instance.
     *
     * @return Webmonks\LaraLogViewer\Contracts\Utilities\LogStyler
     */
    function log_styler()
    {
        return app(Contracts\Utilities\LogStyler::class);
    }
}
