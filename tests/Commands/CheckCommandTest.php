<?php

declare(strict_types=1);

namespace Webmonks\LaraLogViewer\Tests\Commands;

use Webmonks\LaraLogViewer\Tests\TestCase;

/**
 * Class     CheckCommandTest
 *
 * @author   ARCANEDEV <webmonks.in@gmail.com>
 */
class CheckCommandTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_check(): void
    {
        $this->artisan('laravel-log-viewer:check')
             ->assertExitCode(0);
    }
}
