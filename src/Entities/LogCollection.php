<?php

declare(strict_types=1);

namespace Webmonks\LaraLogViewer\Entities;

use Webmonks\LaraLogViewer\Contracts\Utilities\Filesystem as FilesystemContract;
use Webmonks\LaraLogViewer\Exceptions\LogNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\LazyCollection;

/**
 * Class     LogCollection
 *
 * @author   Darshan Baraiya <webmonks.in@gmail.com>
 */
class LogCollection extends LazyCollection
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var \Webmonks\LaraLogViewer\Contracts\Utilities\Filesystem */
    private $filesystem;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * LogCollection constructor.
     *
     * @param  mixed  $source
     */
    public function __construct($source = null)
    {
        $this->setFilesystem(app(FilesystemContract::class));

        if (is_null($source))
            $source = function () {
                foreach($this->filesystem->dates(true) as $date => $path) {
                    yield $date => Log::make($date, $path, $this->filesystem->read($date));
                }
            };

        parent::__construct($source);
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Set the filesystem instance.
     *
     * @param  \Webmonks\LaraLogViewer\Contracts\Utilities\Filesystem  $filesystem
     *
     * @return \Webmonks\LaraLogViewer\Entities\LogCollection
     */
    public function setFilesystem(FilesystemContract $filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get a log.
     *
     * @param  string      $date
     * @param  mixed|null  $default
     *
     * @return \Webmonks\LaraLogViewer\Entities\Log
     *
     * @throws \Webmonks\LaraLogViewer\Exceptions\LogNotFoundException
     */
    public function get($date, $default = null)
    {
        if ( ! $this->has($date))
            throw LogNotFoundException::make($date);

        return parent::get($date, $default);
    }

    /**
     * Paginate logs.
     *
     * @param  int  $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 30)
    {
        $page = request()->get('page', 1);
        $path = request()->url();

        return new LengthAwarePaginator(
            $this->forPage($page, $perPage),
            $this->count(),
            $perPage,
            $page,
            compact('path')
        );
    }

    /**
     * Get a log (alias).
     *
     * @see get()
     *
     * @param  string  $date
     *
     * @return \Webmonks\LaraLogViewer\Entities\Log
     */
    public function log($date)
    {
        return $this->get($date);
    }


    /**
     * Get log entries.
     *
     * @param  string  $date
     * @param  string  $level
     *
     * @return \Webmonks\LaraLogViewer\Entities\LogEntryCollection
     */
    public function entries($date, $level = 'all')
    {
        return $this->get($date)->entries($level);
    }

    /**
     * Get logs statistics.
     *
     * @return array
     */
    public function stats()
    {
        $stats = [];

        foreach ($this->all() as $date => $log) {
            /** @var \Webmonks\LaraLogViewer\Entities\Log $log */
            $stats[$date] = $log->stats();
        }

        return $stats;
    }

    /**
     * List the log files (dates).
     *
     * @return array
     */
    public function dates()
    {
        return $this->keys()->toArray();
    }

    /**
     * Get entries total.
     *
     * @param  string  $level
     *
     * @return int
     */
    public function total($level = 'all')
    {
        return (int) $this->sum(function (Log $log) use ($level) {
            return $log->entries($level)->count();
        });
    }

    /**
     * Get logs tree.
     *
     * @param  bool  $trans
     *
     * @return array
     */
    public function tree($trans = false)
    {
        $tree = [];

        foreach ($this->all() as $date => $log) {
            /** @var \Webmonks\LaraLogViewer\Entities\Log $log */
            $tree[$date] = $log->tree($trans);
        }

        return $tree;
    }

    /**
     * Get logs menu.
     *
     * @param  bool  $trans
     *
     * @return array
     */
    public function menu($trans = true)
    {
        $menu = [];

        foreach ($this->all() as $date => $log) {
            /** @var \Webmonks\LaraLogViewer\Entities\Log $log */
            $menu[$date] = $log->menu($trans);
        }

        return $menu;
    }
}
