<?php

declare(strict_types=1);

namespace Webmonks\LaraLogViewer\Commands;

use Webmonks\LaraLogViewer\Contracts\LaraLogViewer as LaraLogViewerContract;
use Webmonks\Support\Console\Command as BaseCommand;

/**
 * Class     Command
 *
 * @author   Darshan Baraiya <webmonks.in@gmail.com>
 */
abstract class Command extends BaseCommand
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var \Webmonks\LaraLogViewer\Contracts\LaraLogViewer */
    protected $logViewer;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Create the command instance.
     *
     * @param  \Webmonks\LaraLogViewer\Contracts\LaraLogViewer  $logViewer
     */
    public function __construct(LaraLogViewerContract $logViewer)
    {
        parent::__construct();

        $this->logViewer = $logViewer;
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Display LaraLogViewer Logo and Copyrights.
     */
    protected function displayLaraLogViewer()
    {
        // LOGO
        $this->comment('   __                   _                        ');
        $this->comment('  / /  ___   __ _/\   /(_) _____      _____ _ __ ');
        $this->comment(' / /  / _ \ / _` \ \ / / |/ _ \ \ /\ / / _ \ \'__|');
        $this->comment('/ /__| (_) | (_| |\ V /| |  __/\ V  V /  __/ |   ');
        $this->comment('\____/\___/ \__, | \_/ |_|\___| \_/\_/ \___|_|   ');
        $this->comment('            |___/                                ');
        $this->line('');

        // Copyright
        $this->comment('Version '.$this->logViewer->version().' - Created by Darshan Baraiya'.chr(169));
        $this->line('');
    }
}
