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
use SplFileInfo;
use LogicException;
use RuntimeException;
use JsonException;
use DomainException;

/**
 * Trivial implementation of encoder for magic asset
 */
final class EncodedFile implements L\EncodableInterface
{
    /**
     * @var array
     */
    private array $i;
    
    /**
     * Cntr
     * @param L\TasksInterface|null $t
     */
    public function __construct(?L\TasksInterface $t = null)
    {
        $this->i = [
            'tasks' => $t ?? new TkCollection()
        ];
    }
    
    /**
     * @inheritDoc
     */
    public function withFile(string $file): self
    {
        $that = $this->blueprinted();
        $that->i['file'] = $file;
        return $that;
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
     * @throws LogicException|RuntimeException|DomainException
     */
    public function URI(): string
    {
        if (!isset($this->i['secret'])) {
            throw new LogicException("`secret` value is undefined");
        }
        if (!isset($this->i['file'])) {
            throw new LogicException("`file` value is not defined");
        }
        try {
            $data = (function (): string {
                $payload =
                    json_encode(
                        [
                            'file' => $this->i['file'],
                            'tk' => [
                                'classname' => get_class($this->i['tasks']),
                                'state' => $this->i['tasks']->serialized()
                            ]
                        ],
                        JSON_THROW_ON_ERROR
                    );
                return json_encode(
                    [
                        'payload' => $payload,
                        'hash' => hash("sha256", $payload . "@" . $this->i['secret'])
                    ],
                    JSON_THROW_ON_ERROR
                );
            }) ();
        } catch (JsonException $ex) {
            throw new LogicException("Couldn't serialize data", 0, $ex);
        }
        $gziped = false;
        if (function_exists("gzencode")) {
            $data = gzencode($data, 9);
            $gziped = true;
        }
        for ($i = 0; $i < strlen($data); $i++) {
            $data[$i] = chr(ord($data[$i]) ^ ord($this->i['secret']));
        }
        return
            implode(
                "",
                [
                    $gziped? "_": "",
                    str_replace("=", "", base64_encode($data)),
                    (function (string $file) {
                        $ext = (new SplFileInfo($file))->getExtension();
                        if (!empty($ext)) {
                            $ext = "." . $ext;
                        }
                        return $ext;
                    }) ($this->i['file'])
                ]
            );
    }
    
    /**
     * @inheritDoc
     */
    public function withTasks(L\TasksInterface $t): self
    {
        $that = $this->blueprinted();
        $that->i['tasks'] = $t;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function tasks(): L\TasksInterface
    {
        return $this->i['tasks'];
    }
    
    /**
     * Clones the instance
     * @return EncodedFile
     */
    public function blueprinted(): self
    {
        $that = new self();
        $that->i = $this->i;
        return $that;
    }
}
