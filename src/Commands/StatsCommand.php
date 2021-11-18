<?php

declare(strict_types=1);

namespace Webmonks\LaraLogViewer\Commands;

use Webmonks\LaraLogViewer\Tables\StatsTable;

/**
 * Class     StatsCommand
 *
 * @author   Darshan Baraiya <webmonks.in@gmail.com>
 */
class StatsCommand extends Command
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name        = 'laravel-log-viewer:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display stats of all logs.';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature   = 'laravel-log-viewer:stats';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Load Data
        $stats   = $this->logViewer->statsTable('en');

        $rows    = $stats->rows();
        $rows[]  = $this->tableSeparator();
        $rows[]  = $this->prepareFooter($stats);

        // Display Data
        $this->displayLaraLogViewer();
        $this->table($stats->header(), $rows);
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Prepare footer.
     *
     * @param  \Webmonks\LaraLogViewer\Tables\StatsTable  $stats
     *
     * @return array
     */
    private function prepareFooter(StatsTable $stats)
    {
        $files = [
            'count' => count($stats->rows()).' log file(s)'
        ];

        return $files + $stats->footer();
    }
}
