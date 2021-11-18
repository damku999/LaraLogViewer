<?php

declare(strict_types=1);

namespace Webmonks\LaraLogViewer\Exceptions;

/**
 * Class     FilesystemException
 *
 * @author   Darshan Baraiya <webmonks.in@gmail.com>
 */
class FilesystemException extends LaraLogViewerException
{
    public static function cannotDeleteLog()
    {
        return new static('There was an error deleting the log.');
    }

    public static function invalidPath(string $path)
    {
        return new static("The log(s) could not be located at : $path");
    }
}
