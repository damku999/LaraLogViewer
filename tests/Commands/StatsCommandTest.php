<?php

declare(strict_types=1);

namespace Webmonks\LaraLogViewer\Tests\Commands;

use Webmonks\LaraLogViewer\Tests\TestCase;

/**
 * Class     StatsCommandTest
 *
 * @author   ARCANEDEV <webmonks.in@gmail.com>
 */
class StatsCommandTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_display_stats(): void
    {
        $this->artisan('laravel-log-viewer:stats')
             ->assertExitCode(0);
    }
}
