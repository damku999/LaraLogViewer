<?php

declare(strict_types=1);

namespace Webmonks\LaraLogViewer\Exceptions;

/**
 * Class     LogNotFoundException
 *
 * @author   Darshan Baraiya <webmonks.in@gmail.com>
 */
class LogNotFoundException extends LaraLogViewerException
{
    /**
     * Make the exception.
     *
     * @param  string  $date
     *
     * @return static
     */
    public static function make(string $date)
    {
        return new static("Log not found in this date [{$date}]");
    }
}
