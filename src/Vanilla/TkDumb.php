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
use MagicAsset\TaskInterface;

/**
 * Dump implementation of `task` contract
 */
final class TkDumb implements L\TaskInterface
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
        $this->i = [
            'n' => 0
        ];
    }
    
    public function with($val)
    {
        $that = $this->blueprinted();
        $that->i['n'] = $val;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function serialized(): array
    {
        return $this->i;
    }
    
    /**
     * @inheritDoc
     */
    public function unserialized(array $data): TaskInterface
    {
        $that = $this->blueprinted();
        $that->i = $data;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        echo $this->i['n'];
    }
    
    /**
     * Clones the instance
     * @return TkDumb
     */
    public function blueprinted(): self
    {
        $that = new self();
        $that->i = $this->i;
        return $that;
    }
}
