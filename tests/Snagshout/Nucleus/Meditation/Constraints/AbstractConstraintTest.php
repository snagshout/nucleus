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

use Snagshout\Nucleus\Meditation\Constraints\AbstractConstraint;
use Snagshout\Nucleus\Meditation\Primitives\ScalarTypes;
use Snagshout\Nucleus\Testing\TestCase;
use Mockery;

/**
 * Class AbstractConstraintTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\Snagshout\Nucleus\Meditation\Constraints
 */
class AbstractConstraintTest extends TestCase
{
    public function testGetDescription()
    {
        $mock = Mockery::mock(AbstractConstraint::class)
            ->makePartial();

        $this->assertInternalType(
            ScalarTypes::SCALAR_STRING,
            $mock->getDescription()
        );
    }
}
