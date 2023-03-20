<?php

namespace Snagshout\Nucleus\Control\Interfaces;

use Snagshout\Nucleus\Data\Interfaces\FunctorInterface;

/**
 * Interface ApplyInterface
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Control\Interfaces
 */
interface ApplyInterface extends FunctorInterface
{
    /**
     * @param ApplyInterface $other
     *
     * @return ApplyInterface
     */
    public function ap(ApplyInterface $other);
}
