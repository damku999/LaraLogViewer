<?php

declare(strict_types=1);

namespace Webmonks\LaraLogViewer\Contracts;

/**
 * Interface  Table
 *
 * @author    Darshan Baraiya <webmonks.in@gmail.com>
 */
interface Table
{
    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get table header.
     *
     * @return array
     */
    public function header();

    /**
     * Get table rows.
     *
     * @return array
     */
    public function rows();

    /**
     * Get table footer.
     *
     * @return array
     */
    public function footer();
}
