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

use Snagshout\Nucleus\Exceptions\LackOfCoffeeException;
use Snagshout\Nucleus\Exceptions\ResolutionException;
use Snagshout\Nucleus\Testing\Impersonator;
use Snagshout\Nucleus\Testing\TestCase;
use Mockery as m;
use Mockery\MockInterface;
use Tests\Snagshout\Nucleus\Testing\ExampleService\ExampleA;
use Tests\Snagshout\Nucleus\Testing\ExampleService\ExampleAInterface;
use Tests\Snagshout\Nucleus\Testing\ExampleService\ExampleB;
use Tests\Snagshout\Nucleus\Testing\ExampleService\ExampleC;
use Tests\Snagshout\Nucleus\Testing\ExampleService\ExampleD;

/**
 * Class ImpersonatorTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\Snagshout\Nucleus\Testing
 */
class ImpersonatorTest extends TestCase
{
    public function testMake()
    {
        $imp = new Impersonator();

        $this->assertTrue($imp->make(ExampleB::class) instanceof ExampleB);

        /** @var ExampleC $result */
        $result = $imp->make(ExampleC::class);

        $this->assertFalse($result->getOne() === $result->getTwo());

        $imp->provide(new ExampleA());
        /** @var ExampleC $result */
        $result = $imp->make(ExampleC::class);

        $this->assertTrue($result->getOne() === $result->getTwo());

        $imp->provide(new ExampleA());
        $imp->provide(m::mock(ExampleAInterface::class));
        /** @var ExampleC $result */
        $result = $imp->make(ExampleC::class);

        $this->assertTrue($result->getOne() !== $result->getTwo());

        $imp->mock(ExampleA::class, function (MockInterface $mock) {
            $mock->shouldReceive('sayHello')->andReturn('Goodbye')->once();
        });
        /** @var ExampleC $result */
        $result = $imp->make(ExampleC::class);

        $this->assertTrue($result->getOne() === $result->getTwo());
        $this->assertEquals('Goodbye', $result->getTwo()->sayHello());
    }

    public function testMakeWithResolutionIssue()
    {
        $imp = new Impersonator();

        $this->expectException(ResolutionException::class);

        $imp->make(ExampleD::class);
    }

    public function testProvide()
    {
        $imp = new Impersonator();

        $instanceA = new ExampleA();
        $imp->provide($instanceA);

        /** @var ExampleB $instanceB */
        $instanceB = $imp->make(ExampleB::class);
        $this->assertEquals($instanceA, $instanceB->getExampleA());
    }

    public function testProvideWithString()
    {
        $imp = new Impersonator();

        $this->expectException(LackOfCoffeeException::class);

        $imp->provide(ExampleA::class);
    }
}
