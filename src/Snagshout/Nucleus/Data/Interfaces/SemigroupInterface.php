<?php

namespace Snagshout\Nucleus\Data\Interfaces;

/**
 * Interface SemigroupInterface
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Data\Interfaces
 */
interface SemigroupInterface
{
    /**
     * Append another semigroup and return the result.
     *
     * @param SemigroupInterface $other
     *
     * @return SemigroupInterface
     */
    public function append(SemigroupInterface $other);
}
