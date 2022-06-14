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

interface EncodableInterface {
    /**
     * Defines a file used for creating `magic asset`
     * @param string $file
     * @return EncodableInterface
     */
    public function withFile(string $file): EncodableInterface;
    
    /**
     * `Defines private secret key used for encoding `
     * @param string $secret
     * @return DecodableInterface
     */
    public function withSecret(string $secret): EncodableInterface;
    
    /**
     * Returns URI for `magic-assets`
     * @return string
     */
    public function URI(): string;
    
    /**
     * Defines Tasks instance are associated with `magic asset`
     * @param TasksInterface $t
     * @return EncodableInterface
     */
    public function withTasks(TasksInterface $t): EncodableInterface;
    
    /**
     * Returns Tasks instance for the operating with tasks
     * @return TasksInterface
     */
    public function tasks(): TasksInterface;
}
