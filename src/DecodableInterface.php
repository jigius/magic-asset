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

interface DecodableInterface {
    /**
     * Loads data about URI from a request
     * @param string $uri
     * @return DecodableInterface
     */
    public function withURI(string $uri): DecodableInterface;
    
    /**
     * Defines private secret key used for decoding
     * @param string $secret
     * @return DecodableInterface
     */
    public function withSecret(string $secret): DecodableInterface;
    
    /**
     * Returns a result of the decoding
     * @param DecodedResultInterface|null $r
     * @return DecodedResultInterface
     */
    public function decoded(?DecodedResultInterface $r = null): DecodedResultInterface;
}
