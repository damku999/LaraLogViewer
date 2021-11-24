<?php

declare(strict_types=1);

namespace Webmonks\LaraLogViewer\Tests\Utilities;

use Webmonks\LaraLogViewer\Tests\TestCase;
use Webmonks\LaraLogViewer\Utilities\LogStyler;
use Illuminate\Support\HtmlString;

/**
 * Class     LogStylerTest
 *
 * @author   ARCANEDEV <webmonks.in@gmail.com>
 */
class LogStylerTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  Webmonks\LaraLogViewer\Utilities\LogStyler */
    private $styler;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    protected function setUp(): void
    {
        parent::setUp();

        $this->styler = $this->app->make(Webmonks\LaraLogViewer\Contracts\Utilities\LogStyler::class);
    }

    protected function tearDown(): void
    {
        unset($this->styler);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_ben_instantiated(): void
    {
        static::assertInstanceOf(LogStyler::class, $this->styler);
    }

    /** @test */
    public function it_can_get_icon(): void
    {
        foreach (self::$logLevels as $level) {
            static::assertMatchesRegExp(
                '/^<i class="fa fa-fw fa-(.*)"><\/i>$/',
                $this->styler->icon($level)->toHtml()
            );
        }
    }

    /** @test */
    public function it_can_get_default_when_icon_not_found(): void
    {
        $icon = $this->styler->icon('danger', $default = 'fa fa-fw fa-danger');

        static::assertInstanceOf(HtmlString::class, $icon);
        static::assertSame('<i class="'.$default.'"></i>', $icon->toHtml());
    }

    /** @test */
    public function it_can_get_color(): void
    {
        foreach (self::$logLevels as $level) {
            static::assertHexColor($this->styler->color($level));
        }
    }

    /** @test */
    public function it_can_get_default_when_color_not_found(): void
    {
        $color = $this->styler->color('danger', $default = '#BADA55');

        static::assertHexColor($color);
        static::assertSame($default, $color);
    }

    /** @test */
    public function it_can_use_helper_to_get_icon(): void
    {
        foreach (self::$logLevels as $level) {
            static::assertMatchesRegExp(
                '/^<i class="fa fa-fw fa-(.*)"><\/i>$/',
                log_styler()->icon($level)->toHtml()
            );
        }
    }

    /** @test */
    public function it_can_use_helper_get_color(): void
    {
        foreach (self::$logLevels as $level) {
            static::assertHexColor(log_styler()->color($level));
        }
    }

    /** @test */
    public function it_can_get_string_to_highlight(): void
    {
        $expected = [
            '^#\d+',
            '^Stack trace:',
        ];

        static::assertSame($expected, $this->styler->toHighlight());
    }
}
