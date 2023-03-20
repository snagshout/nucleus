<?php

namespace Snagshout\Nucleus\Data\Interfaces;

use Snagshout\Nucleus\Control\Interfaces\ApplicativeInterface;

/**
 * Interface ListInterface
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Data\Interfaces
 */
interface ListInterface extends
    MonoidInterface,
    FoldableInterface,
    LeftFoldableInterface,
    ApplicativeInterface,
    IterableInterface
{
    //
}
