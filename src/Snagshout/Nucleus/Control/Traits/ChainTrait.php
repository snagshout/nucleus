<?php

namespace Snagshout\Nucleus\Control\Traits;

use Snagshout\Nucleus\Control\Interfaces\ApplyInterface;
use Snagshout\Nucleus\Control\Interfaces\ChainInterface;

/**
 * Class ChainTrait
 *
 * @method bind(callable $other)
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Control\Traits
 */
trait ChainTrait
{
    /**
     * @param ApplyInterface $other
     *
     * @return ChainInterface
     */
    public function ap(ApplyInterface $other)
    {
        return $this->bind(function (callable $closure) use ($other) {
            return $other->fmap($closure);
        });
    }
}
