<?php

namespace Snagshout\Nucleus\Control\Interfaces;

/**
 * Interface ApplicativeInterface
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Control\Interfaces
 */
interface ApplicativeInterface extends ApplyInterface
{
    /**
     * @param mixed $input
     *
     * @return ApplicativeInterface
     */
    public static function of($input);
}
