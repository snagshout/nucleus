<?php

namespace Snagshout\Nucleus\Control;

use Snagshout\Nucleus\Control\Interfaces\ChainInterface;
use Snagshout\Nucleus\Control\Traits\ChainTrait;

/**
 * Class Chain
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Control
 */
abstract class Chain implements ChainInterface
{
    use ChainTrait;
}
