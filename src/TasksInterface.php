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

interface TasksInterface extends SerializableInterface {
    /**
     * Iterates tasks via a passed callable object
     * @param callable $h
     * @return void
     */
    public function each(callable $h): void;
    
    /**
     * Appends a task
     * @param TaskInterface $t
     * @return TasksInterface
     */
    public function with(TaskInterface $t): TasksInterface;
    
    /**
     * @inheritDoc
     * @return TasksInterface
     */
    public function unserialized(array $data): TasksInterface;
}
