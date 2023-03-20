<?php

namespace Snagshout\Nucleus\Control;

use Closure;
use Snagshout\Nucleus\Control\Interfaces\ApplicativeInterface;
use Snagshout\Nucleus\Control\Interfaces\ApplyInterface;
use Snagshout\Nucleus\Foundation\BaseObject;

/**
 * Class Applicative
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Control
 */
abstract class Applicative extends BaseObject implements ApplicativeInterface
{
    /**
     * @param callable|Closure $closure
     *
     * @return ApplyInterface
     */
    public function fmap(callable $closure)
    {
        return static::of($closure)->ap($this);
    }
}
