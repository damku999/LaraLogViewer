<?php

declare(strict_types=1);

namespace Webmonks\LaraLogViewer\Commands;

use Webmonks\LaraLogViewer\Contracts\Utilities\LogChecker as LogCheckerContract;

/**
 * Class     CheckCommand
 *
 * @author   Darshan Baraiya <webmonks.in@gmail.com>
 */
class CheckCommand extends Command
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
    protected $name      = 'laravel-log-viewer:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all LaraLogViewer requirements.';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-log-viewer:check';

    /* -----------------------------------------------------------------
     |  Getter & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the Log Checker instance.
     *
     * @return \Webmonks\LaraLogViewer\Contracts\Utilities\LogChecker
     */
    protected function getChecker()
    {
        return $this->laravel[LogCheckerContract::class];
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->displayLaraLogViewer();
        $this->displayRequirements();
        $this->displayMessages();
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Display LaraLogViewer requirements.
     */
    private function displayRequirements()
    {
        $requirements = $this->getChecker()->requirements();

        $this->frame('Application requirements');

        $this->table([
            'Status', 'Message'
        ], [
            [$requirements['status'], $requirements['message']]
        ]);
    }

    /**
     * Display LaraLogViewer messages.
     */
    private function displayMessages()
    {
        $messages = $this->getChecker()->messages();

        $rows = [];
        foreach ($messages['files'] as $file => $message) {
            $rows[] = [$file, $message];
        }

        if ( ! empty($rows)) {
            $this->frame('LaraLogViewer messages');
            $this->table(['File', 'Message'], $rows);
        }
    }
}
