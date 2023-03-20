<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\Snagshout\Nucleus\Meditation\Constraints;

use Snagshout\Nucleus\Exceptions\LackOfCoffeeException;
use Snagshout\Nucleus\Meditation\Constraints\ClosureConstraint;
use Snagshout\Nucleus\Testing\TestCase;

/**
 * Class ClosureConstraintTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\Snagshout\Nucleus\Meditation\Constraints
 */
class ClosureConstraintTest extends TestCase
{
    public function testCheck()
    {
        $constraint = new ClosureConstraint(function ($value) {
            return is_array($value);
        });

        $this->assertEqualsMatrix([
            [true, $constraint->check([])],
            [true, $constraint->check(['wow', 'cool'])],
            [false, $constraint->check(false)],
        ]);
    }

    public function testCheckWithInvalid()
    {
        $constraint = new ClosureConstraint(function () {
            return 1;
        });

        $this->expectException(LackOfCoffeeException::class);
        $constraint->check(45);
    }

    public function testGetDescription()
    {
        $constraint = new ClosureConstraint(function ($value) {
            return is_array($value);
        }, 'wow, doges are much special');

        $this->assertEquals(
            'wow, doges are much special',
            $constraint->getDescription()
        );
    }
}
