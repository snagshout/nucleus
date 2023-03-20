<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\Snagshout\Nucleus\Support;

use PHPUnit\Extension\FunctionMocker;
use PHPUnit\Framework\MockObject\MockObject;
use RuntimeException;
use Snagshout\Nucleus\Support\Str;
use Snagshout\Nucleus\Testing\TestCase;

/**
 * Class StrTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\Snagshout\Nucleus\Support
 */
class StrTest extends TestCase
{
    /**
     * @var MockObject
     */
    protected $php;

    public function testCamel()
    {
        $this->assertEquals('snakeCaseStuff', Str::camel('snake_case_stuff'));
        $this->assertEquals('studlyCaseStuff', Str::camel('StudlyCaseStuff'));
    }

    public function testStudly()
    {
        $this->assertEquals('SnakeCaseStuff', Str::studly('snake_case_stuff'));
        $this->assertEquals('CamelCaseStuff', Str::studly('camelCaseStuff'));
    }

    public function testSnake()
    {
        $this->assertEquals('camel_case_stuff', Str::snake('camelCaseStuff'));
        $this->assertEquals(
            'studly_case_stuff',
            Str::snake('StudlyCaseStuff')
        );
    }

    public function testQuickRandom()
    {
        $someInteger = mt_rand(1, 100);

        $this->assertEquals(
            $someInteger,
            strlen(Str::quickRandom($someInteger))
        );
        $this->assertInternalType('string', Str::quickRandom());
        $this->assertEquals(16, strlen(Str::quickRandom()));
    }

    /**
     * @runInSeparateProcess
     */
    public function testRandom()
    {
        $this->assertEquals(16, strlen(Str::random()));

        $someInteger = mt_rand(1, 5);
        $this->assertEquals($someInteger, strlen(Str::random($someInteger)));
        $this->assertInternalType('string', Str::random());
    }

    /**
     * @runInSeparateProcess
     */
    public function testRandomWithMissingFunction()
    {
        $this->expectException(RuntimeException::class);

        $this->php = FunctionMocker::start($this, 'Snagshout\Nucleus\Support')
             ->mockFunction('function_exists')
             ->mockFunction('openssl_random_pseudo_bytes')
             ->getMock();

        $this->php
            ->expects($this->once())
            ->method('function_exists')
            ->will($this->returnValue(false));

        Str::random();
    }

    /**
     * @runInSeparateProcess
     */
    public function testRandomWithFailure()
    {
        $this->expectException(RuntimeException::class);

        $this->php = FunctionMocker::start($this, 'Snagshout\Nucleus\Support')
             ->mockFunction('function_exists')
             ->mockFunction('openssl_random_pseudo_bytes')
             ->getMock();

        $this->php
            ->expects($this->once())
            ->method('function_exists')
            ->will($this->returnValue(true));

        $this->php
            ->expects($this->once())
            ->method('openssl_random_pseudo_bytes')
            ->will($this->returnValue(false));

        Str::random();
    }

    public function testBeginsWith()
    {
        $this->assertEqualsMatrix([
            [true, Str::beginsWith('hello world', 'hello')],
            [true, Str::beginsWith('hello world', '')],
            [false, Str::beginsWith('hello world', 'omg')],
            [false, Str::beginsWith('hello world', 'hello world ')],
        ]);
    }

    public function testEndsWith()
    {
        $this->assertEqualsMatrix([
            [true, Str::endsWith('hello world', 'world')],
            [true, Str::endsWith('hello world', '')],
            [false, Str::endsWith('hello world', 'omg')],
            [false, Str::endsWith('hello world', 'hello world ')],
        ]);
    }
}
