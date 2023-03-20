<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Snagshout\Nucleus\Testing\Traits;

/**
 * Trait ConstructorTesterTrait.
 *
 * @property array constructorTypes
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Testing\Traits
 */
trait ConstructorTesterTrait
{
    /**
     * @return mixed
     */
    abstract protected function make();

    /**
     * Test the constructor of an object.
     *
     * Creates a new instance by using make and optionally checks
     * if it is an instance of a set of classes and interfaces
     */
    public function testConstructor()
    {
        $instance = $this->make();

        $this->assertInternalType('object', $instance);

        if (property_exists($this, 'constructorTypes')) {
            foreach ($this->constructorTypes as $constructorType) {
                $this->assertInstanceOf($constructorType, $instance);
            }
        }
    }
}
