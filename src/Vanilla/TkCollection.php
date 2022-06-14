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

/**
 * Trivial implementation of `tasks` contract
 */
final class TkCollection implements L\TasksInterface
{
    /**
     * @var array
     */
    private array $coll;
    
    /**
     * Cntr
     */
    public function __construct()
    {
        $this->coll = [];
    }
    
    /**
     * @inheritDoc
     */
    public function with(L\TaskInterface $t): self
    {
        $that = $this->blueprinted();
        $that->coll[] = $t;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function serialized(): array
    {
        return
            array_map(
                function (L\TaskInterface $t): array {
                    return [
                        'classname' => get_class($t),
                        'state' => $t->serialized()
                    ];
                },
                $this->coll
            );
    }
    
    /**
     * @inheritDoc
     * @throws LogicException
     */
    public function unserialized(array $data): self
    {
        $r = [];
        foreach ($data as $i) {
            if (
                !isset($i['classname']) ||
                !class_exists($i['classname']) ||
                !class_exists($i['classname']) ||
                !isset($i['state']) ||
                !is_array($i['state'])
            ) {
                throw new LogicException("data is corrupted");
            }
            $t = new $i['classname'];
            if (!$t instanceof L\TaskInterface) {
                throw new LogicException("type invalid");
            }
            $r[] = $t->unserialized($i['state']);
        }
        $that = $this->blueprinted();
        $that->coll = $r;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function each(callable $h): void
    {
        foreach ($this->coll as $t) {
            call_user_func($h, $t);
        }
    }
    
    /**
     * Clones the instance
     * @return TkCollection
     */
    public function blueprinted(): self
    {
        $that = new self();
        $that->coll = $this->coll;
        return $that;
    }
}
