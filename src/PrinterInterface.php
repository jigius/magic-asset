<?php
/**
 * This file is part of the jigius/magic-asset library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) 2022 Jigius <jigius@gmail.com>
 * @link https://github.com/jigius/magic-asset GitHub
 */

namespace MagicAsset;

/**
 * Interface PrinterInterface
 * Adds capability to retrieve a data from other objects
 */
interface PrinterInterface
{
    /**
     * Feeds an instance with new portion of a data for printing
     * @param $key string The key name for passed portion of a data
     * @param $val mixed The value for passed portion of a data
     * @return PrinterInterface
     */
    public function with(string $key, $val): PrinterInterface;

    /**
     * Produces(outputs) a data as result of "printing" process
     * @return mixed
     */
    public function finished();
}
