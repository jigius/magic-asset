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

interface TaskInterface extends SerializableInterface {
    
    /**
     * @inheritDoc
     * @return TaskInterface
     */
    public function unserialized(array $data): TaskInterface;
    
    /**
     * Executes the task
     * @return void
     */
    public function execute(): void;
}
