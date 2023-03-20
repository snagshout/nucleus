<?php

namespace Snagshout\Nucleus\Data;

use Snagshout\Nucleus\Meditation\Boa;
use Snagshout\Nucleus\Meditation\Constraints\PrimitiveTypeConstraint;

/**
 * Class IndexedCollection.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Data
 */
abstract class IndexedCollection extends Collection
{
    /**
     * @return PrimitiveTypeConstraint
     */
    public function getKeyType()
    {
        return Boa::integer();
    }
}
