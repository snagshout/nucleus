<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\Snagshout\Nucleus\Meditation;

use Snagshout\Nucleus\Meditation\Arguments;
use Snagshout\Nucleus\Meditation\Constraints\EitherConstraint;
use Snagshout\Nucleus\Meditation\Constraints\MaybeConstraint;
use Snagshout\Nucleus\Meditation\Constraints\PrimitiveTypeConstraint;
use Snagshout\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use Snagshout\Nucleus\Meditation\Primitives\CompoundTypes;
use Snagshout\Nucleus\Meditation\Primitives\ScalarTypes;
use Snagshout\Nucleus\Testing\TestCase;
use stdClass;

/**
 * Class ArgumentsTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\Snagshout\Nucleus\Meditation
 */
class ArgumentsTest extends TestCase
{
    public function testDefine()
    {
        $this->expectNotToPerformAssertions();

        Arguments::define(
            PrimitiveTypeConstraint::forType(ScalarTypes::SCALAR_STRING)
        )->check('wow');
    }

    public function testDefineWithMismatch()
    {
        $this->expectException(
            InvalidArgumentException::class,
            'Argument number mismatch.'
        );

        Arguments::define(
            PrimitiveTypeConstraint::forType(ScalarTypes::SCALAR_STRING)
        )->check('wow', new stdClass());
    }

    public function testDefineWithInvalid()
    {
        $definition = Arguments::define(
            PrimitiveTypeConstraint::forType(ScalarTypes::SCALAR_STRING),
            EitherConstraint::create(
                MaybeConstraint::forType(PrimitiveTypeConstraint::forType(
                    CompoundTypes::COMPOUND_ARRAY
                )),
                PrimitiveTypeConstraint::forType(ScalarTypes::SCALAR_BOOLEAN)
            )
        );

        $definition->check('wow', true);
        $definition->check('wow', []);
        $definition->check('wow', null);

        $this->expectException(InvalidArgumentException::class);

        $definition->check('wow', 25);
    }
}
