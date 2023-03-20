<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\Snagshout\Nucleus\Testing;

use ArrayIterator;
use PHPUnit\Framework\ExpectationFailedException;
use Snagshout\Nucleus\Testing\TestCase;

/**
 * Class TestCaseTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\Snagshout\Nucleus\Testing
 */
class TestCaseTest extends \PHPUnit\Framework\TestCase
{
    public function testAssertInstanceOf()
    {
        /** @var TestCase $case */
        $case = $this->getMockForAbstractClass(TestCase::class);

        $case->assertInstanceOf('ArrayIterator', new ArrayIterator());

        $case->assertInstanceOf('Iterator', new ArrayIterator());
    }

    public function testAssertInstanceOfWithInvalid()
    {
        $this->expectException(ExpectationFailedException::class);

        /** @var TestCase $case */
        $case = $this->getMockForAbstractClass(TestCase::class);

        $case->assertInstanceOf('EmptyIterator', new ArrayIterator());
    }

    public function testAssertInstanceOfWithMultipleInvalid()
    {
        $this->expectException(ExpectationFailedException::class);

        /** @var TestCase $case */
        $case = $this->getMockForAbstractClass(TestCase::class);

        $case->assertInstanceOf('ArrayIterator', new ArrayIterator());

        $case->assertInstanceOf('EmptyIterator', new ArrayIterator());
    }
}
