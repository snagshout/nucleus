<?php

namespace Snagshout\Nucleus\Data\Traits;

use Snagshout\Nucleus\Data\Exceptions\MismatchedDataTypesException;

/**
 * Class SameTypeTrait
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Data\Traits
 */
trait SameTypeTrait
{
    /**
     * Ensure that the received value is the same type as this class.
     *
     * @param string|object $received
     *
     * @throws MismatchedDataTypesException
     */
    protected function assertSameType($received)
    {
        if (!$received instanceof static) {
            $this->throwMismatchedDataTypeException($received);
        }
    }

    /**
     * @param string|object $received
     *
     * @throws MismatchedDataTypesException
     */
    protected function throwMismatchedDataTypeException($received)
    {
        throw MismatchedDataTypesException::create(
            static::class,
            $received
        );
    }
}
