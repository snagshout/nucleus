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

use Snagshout\Nucleus\Meditation\Primitives\SpecialTypes;

/**
 * Class MaybeConstraint.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Meditation\Constraints
 */
class MaybeConstraint extends EitherConstraint
{
    /**
     * Construct an instance of a MaybeConstraint.
     *
     * @param AbstractConstraint $other
     */
    public function __construct(AbstractConstraint $other)
    {
        parent::__construct(
            $other,
            new PrimitiveTypeConstraint(SpecialTypes::SPECIAL_NULL)
        );
    }

    /**
     * Construct an instance of a MaybeConstraint.
     *
     * @param AbstractConstraint $other
     *
     * @return static
     */
    public static function forType(AbstractConstraint $other)
    {
        return new static($other);
    }
}
