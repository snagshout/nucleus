<?php

namespace Snagshout\Nucleus\Data\Interfaces;

use Closure;

/**
 * Interface FunctorInterface
 *
 * WIP
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Monads\Interfaces
 */
interface FunctorInterface
{
    /**
     * Apply a function to this functor.
     *
     * @param callable|Closure $closure
     *
     * @return FunctorInterface
     */
    public function fmap(callable $closure);
}
