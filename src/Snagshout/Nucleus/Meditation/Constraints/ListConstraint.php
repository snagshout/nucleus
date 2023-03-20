<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Snagshout\Nucleus\Meditation\Constraints;

use ArrayObject;
use Snagshout\Nucleus\Data\Interfaces\ListInterface;
use Snagshout\Nucleus\Meditation\Primitives\CompoundTypes;

/**
 * Class ListConstraint.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Meditation\Constraints
 */
class ListConstraint extends EitherConstraint
{
    /**
     * Construct an instance of a ListConstraint.
     */
    public function __construct()
    {
        parent::__construct(
            new ClassTypeConstraint(ListInterface::class),
            new EitherConstraint(
                new ClassTypeConstraint(ArrayObject::class),
                new PrimitiveTypeConstraint(CompoundTypes::COMPOUND_ARRAY)
            )
        );
    }
}
