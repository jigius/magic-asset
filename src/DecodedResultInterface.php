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

interface DecodedResultInterface
{
    /**
     * Defines an input data used for extracting info about tasks and file
     * @param array $i
     * @return DecodedResultInterface
     */
    public function with(array $i): DecodedResultInterface;
    
    /**
     * Processes defined input data
     * @return DecodedResultInterface
     */
    public function decoded(): DecodedResultInterface;
    
    /**
     * Returns a path on the local disk to a file for a decoded magic asset
     * @return string
     */
    public function file(): string;
    
    /**
     * Returns Tasks instance for the operating with tasks
     * @return TasksInterface
     */
    public function tasks(): TasksInterface;
}
