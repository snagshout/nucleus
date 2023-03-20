<?php

namespace Snagshout\Nucleus\Data\Interfaces;

/**
 * Interface MonoidInterface
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Data\Interfaces
 */
interface MonoidInterface extends SemigroupInterface
{
    /**
     * Get an empty monoid.
     *
     * @return MonoidInterface
     */
    public static function zero();
}
