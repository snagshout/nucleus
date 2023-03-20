<?php

namespace Snagshout\Nucleus\Control\Interfaces;

use Closure;

/**
 * Interface ChainInterface
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Control\Interfaces
 */
interface ChainInterface extends ApplyInterface
{
    /**
     * @param callable|Closure $closure
     *
     * @return ChainInterface
     */
    public function bind(callable $closure);
}
