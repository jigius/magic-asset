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
use MagicAsset\DecodedResultInterface;

final class DecodedResult implements L\DecodedResultInterface
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
    public function with(array $i): DecodedResultInterface
    {
        $that = $this->blueprinted();
        $that->i['i'] = $i;
        return $that;
    }
    
    /**
     * @inheritDoc
     * @throws LogicException
     */
    public function decoded(): self
    {
        if (!isset($this->i['i'])) {
            throw new LogicException("There is no input data");
        }
        if (empty($this->i['i']['file']) || !is_string($this->i['i']['file'])) {
            throw new LogicException("data is corrupted");
        }
        if (
            !isset($this->i['i']['tk']['classname']) ||
            !is_string($this->i['i']['tk']['classname']) ||
            !class_exists($this->i['i']['tk']['classname']) ||
            !isset($this->i['i']['tk']['state']) ||
            !is_array($this->i['i']['tk']['state'])
        ) {
            throw new LogicException("data is corrupted");
        }
        $tk = new $this->i['i']['tk']['classname'];
        if (!$tk instanceof L\TasksInterface) {
            throw new LogicException("data is corrupted");
        }
        $tk = $tk->unserialized($this->i['i']['tk']['state']);
        $that = $this->blueprinted();
        $that->i['tasks'] = $tk;
        $that->i['file'] = $this->i['i']['file'];
        return $that;
    }
    
    /**
     * @inheritDoc
     * @throws LogicException
     */
    public function file(): string
    {
        if (!isset($this->i['file'])) {
            throw new LogicException("has not been processed yet");
        }
        return $this->i['file'];
    }
    
    /**
     * @inheritDoc
     */
    public function tasks(): L\TasksInterface
    {
        if (!isset($this->i['tasks'])) {
            throw new LogicException("has not been processed yet");
        }
        return $this->i['tasks'];
    }
    
    /**
     * Clones the instance
     * @return DecodedResult
     */
    public function blueprinted(): self
    {
        $that = new self();
        $that->i = $this->i;
        return $that;
    }
}
