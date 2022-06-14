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
 * Interface SerializableInterface
 * Adds capability to an instance to be serialized to and unserialized from an array
 */
interface SerializableInterface
{

    /**
     * Creates an object from its serialized state
     * @param iterable $data
     * @return mixed
     */
    public function unserialized(array $data);

    /**
     * Creates a serialized object's state in form of an iterable
     * @return array
     */
    public function serialized(): array;
}
