<?php

namespace Chromabits\Nucleus\Data\Interfaces;

/**
 * Interface ReadMapInterface
 *
 * A read-only Map.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data\Interfaces
 */
interface ReadMapInterface
{
    /**
     * Get the value of the provided key.
     *
     * @param string $key
     *
     * @return static
     */
    public function lookup($key);

    /**
     * Return whether or not the map contains the specified key.
     *
     * @param string $key
     *
     * @return bool
     */
    public function member($key);
}
