<?php

namespace Snagshout\Nucleus\Data;

use Snagshout\Nucleus\Meditation\Constraints\AbstractTypeConstraint;

/**
 * Class SetCollection.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Data
 */
abstract class SetCollection extends Collection
{
    /**
     * @return AbstractTypeConstraint
     */
    public function getKeyType()
    {
        return $this->getValueType();
    }
}
