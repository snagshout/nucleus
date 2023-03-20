<?php

namespace Snagshout\Nucleus\Data\Interfaces;

/**
 * Interface TraversableInterface
 *
 * @TODO THIS IS WORK IN PROGRESS. AVOID IMPLEMENTING.
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Data\Interfaces
 */
interface TraversableInterface extends FunctorInterface
{
    /**
     * @return mixed
     */
    public function sequence();
}
