<?php

namespace Snagshout\Nucleus\Control;

/**
 * Class Nothing
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Control
 */
class Nothing extends Maybe
{
    protected $value = null;

    /**
     * @inheritdoc
     */
    public function isJust()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function isNothing()
    {
        return true;
    }
}
