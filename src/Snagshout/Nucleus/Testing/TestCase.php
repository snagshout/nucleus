<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Snagshout\Nucleus\Testing;

use Exception;
use Snagshout\Nucleus\Exceptions\LackOfCoffeeException;
use Snagshout\Nucleus\Meditation\Primitives\CompoundTypes;
use Snagshout\Nucleus\Meditation\Primitives\ScalarTypes;
use Snagshout\Nucleus\Meditation\Primitives\SpecialTypes;

/**
 * Class TestCase.
 *
 * A base test case with some extra assertions
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Testing
 */
abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Run assert equals with an input matrix.
     *
     * Every entry should be formatted as following:
     *
     * [$expected, $equals, $message (optional)]
     *
     * @param array $comparisons
     *
     * @throws LackOfCoffeeException
     */
    public static function assertEqualsMatrix(array $comparisons)
    {
        $total = count($comparisons);

        foreach ($comparisons as $index => $comparison) {
            if (count($comparison) < 2) {
                throw new LackOfCoffeeException('Comparison entry is invalid.');
            }

            if (array_key_exists(2, $comparison)) {
                $message = $comparison[2];
            } else {
                $message = vsprintf(
                    'Comparison %d (of %d) is expected to be equal.',
                    [$index + 1, $total]
                );
            }

            static::assertEquals(
                $comparison[0],
                $comparison[1],
                $message
            );
        }
    }

    /**
     * Assert that an object has all attributes in an array.
     *
     * @param array $attributes
     * @param mixed $object
     * @param string $message
     */
    public function assertObjectHasAttributes(
        array  $attributes,
               $object,
        string $message = ''
    )
    {
        foreach ($attributes as $attr) {
            $this->assertIsObject($object);
            $this->assertTrue(property_exists($object, $attr), $message);
        }
    }


    /**
     * Assert the provided input of a certain internal (scalar) type.
     *
     * @param string $expected
     * @param mixed $actual
     * @param string $message
     */
    public function assertInternalType(
        string $expected,
               $actual,
        string $message = ''
    )
    {
        if (in_array($expected, ScalarTypes::getValues())) {
            $this->assertTrue((new ScalarTypes())->check($expected, $actual), $message);
            return;
        }

        if (in_array($expected, CompoundTypes::getValues())) {
            $this->assertTrue((new CompoundTypes())->check($expected, $actual), $message);
            return;
        }

        if (in_array($expected, SpecialTypes::getValues())) {
            $this->assertTrue((new SpecialTypes())->check($expected, $actual), $message);
            return;
        }

        throw new Exception('No such internal type: ' . $expected);
    }
}
