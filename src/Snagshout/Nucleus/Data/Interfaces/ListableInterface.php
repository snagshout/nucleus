<?php

namespace Snagshout\Nucleus\Data\Interfaces;

/**
 * Interface ListableInterface
 *
 * An object that can be converted or represented as a ListInterface.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Data\Interfaces
 */
interface ListableInterface
{
    /**
     * @return ListInterface
     */
    public function toList();
}
