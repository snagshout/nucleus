<?php

namespace Snagshout\Nucleus\Data\Interfaces;

/**
 * Interface FoldableInterface
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Data\Interfaces
 */
interface FoldableInterface
{
    /**
     * @param callable $closure
     * @param mixed $initial
     *
     * @return static|FoldableInterface
     */
    public function foldr(callable $closure, $initial);
}
