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
 * Interface MediaInterface
 * Adds capability to printing out itself into passed object with using of `PrinterInterface` contract
 */
interface MediaInterface
{
    /**
     * Prints out the current instance to printer object
     * (that is implementing `PrinterInterface` contract)
     * and returns some result from that object
     * @param PrinterInterface $printer
     * @return mixed
     */
    public function printed(PrinterInterface $printer);
}
