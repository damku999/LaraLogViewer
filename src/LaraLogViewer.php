<?php

declare(strict_types=1);

namespace Webmonks\LaraLogViewer;

use Webmonks\LaraLogViewer\Contracts\Utilities\Filesystem as FilesystemContract;
use Webmonks\LaraLogViewer\Contracts\Utilities\Factory as FactoryContract;
use Webmonks\LaraLogViewer\Contracts\Utilities\LogLevels as LogLevelsContract;
use Webmonks\LaraLogViewer\Contracts\LaraLogViewer as LaraLogViewerContract;

/**
 * Class     LaraLogViewer
 *
 * @author   Darshan Baraiya <webmonks.in@gmail.com>
 */
class LaraLogViewer implements LaraLogViewerContract
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    /**
     * LaraLogViewer Version
     */
    const VERSION = '8.1.0';

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The factory instance.
     *
     * @var \Webmonks\LaraLogViewer\Contracts\Utilities\Factory
     */
    protected $factory;

    /**
     * The filesystem instance.
     *
     * @var \Webmonks\LaraLogViewer\Contracts\Utilities\Filesystem
     */
    protected $filesystem;

    /**
     * The log levels instance.
     *
     * @var \Webmonks\LaraLogViewer\Contracts\Utilities\LogLevels
     */
    protected $levels;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Create a new instance.
     *
     * @param \Webmonks\LaraLogViewer\Contracts\Utilities\Factory $factory
     * @param \Webmonks\LaraLogViewer\Contracts\Utilities\Filesystem $filesystem
     * @param \Webmonks\LaraLogViewer\Contracts\Utilities\LogLevels $levels
     */
    public function __construct(
        FactoryContract $factory,
        FilesystemContract $filesystem,
        LogLevelsContract $levels
    ) {
        $this->factory = $factory;
        $this->filesystem = $filesystem;
        $this->levels = $levels;
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the log levels.
     *
     * @param bool $flip
     *
     * @return array
     */
    public function levels($flip = false)
    {
        return $this->levels->lists($flip);
    }

    /**
     * Get the translated log levels.
     *
     * @param string|null $locale
     *
     * @return array
     */
    public function levelsNames($locale = null)
    {
        return $this->levels->names($locale);
    }

    /**
     * Set the log storage path.
     *
     * @param string $path
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->factory->setPath($path);

        return $this;
    }

    /**
     * Get the log pattern.
     *
     * @return string
     */
    public function getPattern()
    {
        return $this->factory->getPattern();
    }

    /**
     * Set the log pattern.
     *
     * @param string $date
     * @param string $prefix
     * @param string $extension
     *
     * @return self
     */
    public function setPattern(
        $prefix = FilesystemContract::PATTERN_PREFIX,
        $date = FilesystemContract::PATTERN_DATE,
        $extension = FilesystemContract::PATTERN_EXTENSION
    ) {
        $this->factory->setPattern($prefix, $date, $extension);

        return $this;
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get all logs.
     *
     * @return \Webmonks\LaraLogViewer\Entities\LogCollection
     */
    public function all()
    {
        return $this->factory->all();
    }

    /**
     * Paginate all logs.
     *
     * @param int $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 30)
    {
        return $this->factory->paginate($perPage);
    }

    /**
     * Get a log.
     *
     * @param string $date
     *
     * @return \Webmonks\LaraLogViewer\Entities\Log
     */
    public function get($date)
    {
        return $this->factory->log($date);
    }

    /**
     * Get the log entries.
     *
     * @param string $date
     * @param string $level
     *
     * @return \Webmonks\LaraLogViewer\Entities\LogEntryCollection
     */
    public function entries($date, $level = 'all')
    {
        return $this->factory->entries($date, $level);
    }

    /**
     * Download a log file.
     *
     * @param string $date
     * @param string|null $filename
     * @param array $headers
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($date, $filename = null, $headers = [])
    {
        if (is_null($filename)) {
            $filename = sprintf(
                "%s{$date}.%s",
                config('laravel-log-viewer.download.prefix', 'laravel-'),
                config('laravel-log-viewer.download.extension', 'log')
            );
        }

        $path = $this->filesystem->path($date);

        return response()->download($path, $filename, $headers);
    }

    /**
     * Get logs statistics.
     *
     * @return array
     */
    public function stats()
    {
        return $this->factory->stats();
    }

    /**
     * Get logs statistics table.
     *
     * @param string|null $locale
     *
     * @return \Webmonks\LaraLogViewer\Tables\StatsTable
     */
    public function statsTable($locale = null)
    {
        return $this->factory->statsTable($locale);
    }

    /**
     * Delete the log.
     *
     * @param string $date
     *
     * @return bool
     */
    public function delete($date)
    {
        return $this->filesystem->delete($date);
    }

    /**
     * Clear the log files.
     *
     * @return bool
     */
    public function clear()
    {
        return $this->filesystem->clear();
    }

    /**
     * Get all valid log files.
     *
     * @return array
     */
    public function files()
    {
        return $this->filesystem->logs();
    }

    /**
     * List the log files (only dates).
     *
     * @return array
     */
    public function dates()
    {
        return $this->factory->dates();
    }

    /**
     * Get logs count.
     *
     * @return int
     */
    public function count()
    {
        return $this->factory->count();
    }

    /**
     * Get entries total from all logs.
     *
     * @param string $level
     *
     * @return int
     */
    public function total($level = 'all')
    {
        return $this->factory->total($level);
    }

    /**
     * Get logs tree.
     *
     * @param bool $trans
     *
     * @return array
     */
    public function tree($trans = false)
    {
        return $this->factory->tree($trans);
    }

    /**
     * Get logs menu.
     *
     * @param bool $trans
     *
     * @return array
     */
    public function menu($trans = true)
    {
        return $this->factory->menu($trans);
    }

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
     */

    /**
     * Determine if the log folder is empty or not.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->factory->isEmpty();
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the LaraLogViewer version.
     *
     * @return string
     */
    public function version()
    {
        return self::VERSION;
    }
}
