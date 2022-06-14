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
namespace MagicAsset\Vanilla;

use MagicAsset as L;
use LogicException;
use RuntimeException;
use JsonException;
use DomainException;

/**
 * Trivial implementation of decoder for magic asset
 */
final class DecodedURI implements L\DecodableInterface
{
    /**
     * @var array
     */
    private array $i;
    
    /**
     * Cntr
     */
    public function __construct()
    {
        $this->i = [];
    }
    
    /**
     * @inheritDoc
     */
    public function withSecret(string $secret): self
    {
        $that = $this->blueprinted();
        $that->i['secret'] = $secret;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withURI(string $uri): self
    {
        $that = $this->blueprinted();
        $that->i['uri'] = $uri;
        return $that;
    }
    
    /**
     * @inheritDoc
     * @throws LogicException|DomainException
     */
    public function decoded(?L\DecodedResultInterface $r = null): L\DecodedResultInterface
    {
        if (!isset($this->i['secret'])) {
            throw new LogicException("`secret` value is undefined");
        }
        if (!isset($this->i['uri'])) {
            throw new LogicException("`uri` value is not defined");
        }
        $data = $this->i['uri'];
        $gziped = false;
        if ($data[0] === "_") {
            $gziped = true;
            $data = substr($data, 1);
        }
        if (($pos = strpos($this->i['uri'], ".")) !== false) {
            $data = substr($data, 0, $pos);
        }
        if (($rest = strlen($data) % 4) > 0) {
            $data = $data . str_repeat("=", $rest);
        }
        if (($data = base64_decode($data)) === false) {
           throw new DomainException("data is corrupted");
        }
        for ($i = 0; $i < strlen($data); $i++) {
            $data[$i] = chr(ord($data[$i]) ^ ord($this->i['secret']));
        }
        if ($gziped) {
            if (!function_exists('gzdecode')) {
                throw
                new DomainException(
                    "Environment is not meet to handle URI",
                    0,
                    new RuntimeException(
                        "URI is decoded with `gzdecode()` but the module is not turned on"
                    )
                );
            }
            if (($data = gzdecode($data)) === false) {
                throw
                new DomainException(
                    "couldn't encode URI",
                    0,
                    new RuntimeException("`gzencode()` returned false")
                );
            }
        }
        try {
            $data = json_decode(
                $data,
                true,
                512,
                JSON_THROW_ON_ERROR
            );
            if (!isset($data['payload']) || !isset($data['hash'])) {
                throw new DomainException("data is corrupted");
            }
            if (hash("sha256", $data['payload'] . "@" . $this->i['secret']) !== $data['hash']) {
                throw new DomainException("data is not authorized", 403);
            }
            $data = json_decode(
                $data['payload'],
                true,
                512,
                JSON_THROW_ON_ERROR
            );
            if (!is_array($data)) {
                throw new LogicException("type invalid");
            }
            return ($r ?? new DecodedResult())->with($data)->decoded();
        } catch (JsonException $ex) {
            throw new LogicException("Couldn't unserialize data", 0, $ex);
        }
    }
    
    /**
     * Clones the instance
     * @return DecodedURI
     */
    public function blueprinted(): self
    {
        $that = new self();
        $that->i = $this->i;
        return $that;
    }
}
