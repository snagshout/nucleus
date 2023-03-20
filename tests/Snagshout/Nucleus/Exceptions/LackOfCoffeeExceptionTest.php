<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\Snagshout\Nucleus\Exceptions;

use Snagshout\Nucleus\Exceptions\LackOfCoffeeException;
use Snagshout\Nucleus\Testing\TestCase;

/**
 * Class LackOfCoffeeExceptionTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\Snagshout\Nucleus\Exceptions
 */
class LackOfCoffeeExceptionTest extends TestCase
{
    public function testConstructor()
    {
        $one = new LackOfCoffeeException();

        $this->assertEquals(
            '(╯°□°）╯︵ ┻━┻ Coffee time!',
            $one->getMessage()
        );

        $two = new LackOfCoffeeException('You need some sleep man');

        $this->assertEquals(
            '(╯°□°）╯︵ ┻━┻ You need some sleep man',
            $two->getMessage()
        );
    }
}
