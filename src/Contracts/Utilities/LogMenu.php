<?php

declare(strict_types=1);

namespace Webmonks\LaraLogViewer\Contracts\Utilities;

use Webmonks\LaraLogViewer\Entities\Log;
use Illuminate\Contracts\Config\Repository as ConfigContract;

/**
 * Interface  LogMenu
 *
 * @author    Darshan Baraiya <webmonks.in@gmail.com>
 */
interface LogMenu
{
    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Set the config instance.
     *
     * @param  \Illuminate\Contracts\Config\Repository  $config
     *
     * @return self
     */
    public function setConfig(ConfigContract $config);

    /**
     * Set the log styler instance.
     *
     * @param  \Webmonks\LaraLogViewer\Contracts\Utilities\LogStyler  $styler
     *
     * @return self
     */
    public function setLogStyler(LogStyler $styler);

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Make log menu.
     *
     * @param  \Webmonks\LaraLogViewer\Entities\Log  $log
     * @param  bool                               $trans
     *
     * @return array
     */
    public function make(Log $log, $trans = true);
}
