<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\Snagshout\Nucleus\Testing\Traits;

use PHPUnit\Framework\MockObject\MockObject;
use Snagshout\Nucleus\Testing\TestCase;
use Snagshout\Nucleus\Testing\Traits\ConstructorTesterTrait;

/**
 * Class ConstructorTesterHelper.
 *
 * This is not a unit test. It's merely a class for testing a trait
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\Snagshout\Nucleus\Testing\Traits
 */
class ConstructorTesterHelper extends TestCase
{
    use ConstructorTesterTrait;

    protected $constructorTypes = [
        'Snagshout\Nucleus\Testing\TestCase',
    ];

    /**
     * @return MockObject
     */
    protected function make()
    {
        return $this->getMockForAbstractClass(TestCase::class);
    }

    /**
     * Sets multiple types.
     */
    public function setMultipleTypes()
    {
        $this->constructorTypes = [
            'PHPUnit\Framework\TestCase',
            'Snagshout\Nucleus\Testing\TestCase',
        ];
    }

    /**
     * Sets no types.
     */
    public function setNoTypes()
    {
        $this->constructorTypes = [];
    }
}
