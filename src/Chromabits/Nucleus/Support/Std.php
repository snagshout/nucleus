<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Support;

use Chromabits\Nucleus\Data\Factories\ComplexFactory;
use Chromabits\Nucleus\Data\Interfaces\FoldableInterface;
use Chromabits\Nucleus\Data\Interfaces\LeftFoldableInterface;
use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Foundation\StaticObject;
use Chromabits\Nucleus\Meditation\Arguments;
use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use Chromabits\Nucleus\Meditation\Exceptions\MismatchedArgumentTypesException;
use Chromabits\Nucleus\Meditation\Primitives\ScalarTypes;
use Chromabits\Nucleus\Meditation\TypeHound;
use Chromabits\Nucleus\Strings\Rope;
use Closure;
use Exception;
use ReflectionFunction;
use Traversable;

/**
 * Class Std.
 *
 * A standard library of functions.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Support
 */
class Std extends StaticObject
{
    /**
     * Applies function fn to the argument list args. This is useful for
     * creating a fixed-arity function from a variadic function. fn should be a
     * bound function if context is significant. (From Ramda).
     *
     * @param callable $function
     * @param array|Traversable $args
     *
     * @return mixed
     */
    public static function apply(callable $function, $args)
    {
        Arguments::contain(Boa::func(), Boa::lst())->check($function, $args);

        return static::call($function, ...$args);
    }

    /**
     * Concatenate the two provided values.
     *
     * @param string|array|Traversable $one
     * @param string|array|Traversable $other
     *
     * @throws MismatchedArgumentTypesException
     * @throws InvalidArgumentException
     * @return mixed
     */
    public static function concat($one, $other)
    {
        Arguments::contain(
            Boa::either(
                Boa::lst(),
                Boa::string()
            ),
            Boa::either(
                Boa::lst(),
                Boa::string()
            )
        )->check($one, $other);

        $oneType = TypeHound::fetch($one);
        $twoType = TypeHound::fetch($other);

        if ($oneType !== $twoType) {
            throw new MismatchedArgumentTypesException(
                __FUNCTION__,
                $one,
                $other
            );
        }

        if ($oneType === ScalarTypes::SCALAR_STRING) {
            return $one . $other;
        }

        return array_merge($one, $other);
    }

    /**
     * Return the first non-false argument.
     *
     * Default: false
     *
     * @param mixed ...$args
     *
     * @return bool
     */
    public static function truthy(...$args)
    {
        foreach ($args as $arg) {
            if ($arg) {
                return $arg;
            }
        }

        return false;
    }

    /**
     * Return the first non-true argument.
     *
     * Default: true
     *
     * @param mixed ...$args
     *
     * @return bool
     */
    public static function falsy(...$args)
    {
        foreach ($args as $arg) {
            if (!$arg) {
                return $arg;
            }
        }

        return true;
    }

    /**
     * Return the first non-null argument.
     *
     * @param mixed ...$args
     *
     * @return mixed
     */
    public static function coalesce(...$args)
    {
        foreach ($args as $arg) {
            if ($arg !== null) {
                return $arg;
            }
        }

        return null;
    }

    /**
     * Call the provided function on each element.
     *
     * @param callable $function
     * @param array|Traversable|LeftFoldableInterface $foldable
     *
     * @throws InvalidArgumentException
     */
    public static function each(callable $function, $foldable)
    {
        Arguments::contain(Boa::func(), Boa::foldable())
            ->check($function, $foldable);

        static::map($function, $foldable);
    }

    /**
     * Return the first non-empty argument.
     *
     * @param mixed ...$args
     *
     * @return null|mixed
     */
    public static function nonempty(...$args)
    {
        foreach ($args as $arg) {
            if (!empty($arg)) {
                return $arg;
            }
        }

        return null;
    }

    /**
     * Check if a value is between two other values.
     *
     * @param int|float $min
     * @param int|float $max
     * @param int|float $value
     *
     * @throws LackOfCoffeeException
     * @return bool
     */
    public static function within($min, $max, $value)
    {
        Arguments::contain(
            Boa::either(Boa::integer(), Boa::float()),
            Boa::either(Boa::integer(), Boa::float()),
            Boa::either(Boa::integer(), Boa::float())
        )->check($min, $max, $value);

        if ($min > $max) {
            throw new LackOfCoffeeException(
                'Max value is less than the min value.'
            );
        }

        return ($min <= $value && $max >= $value);
    }

    /**
     * Create a new instance of a rope.
     *
     * @param string $string
     * @param null $encoding
     *
     * @return Rope
     */
    public static function rope($string, $encoding = null)
    {
        Arguments::contain(Boa::string(), Boa::maybe(Boa::string()))
            ->check($string, $encoding);

        return new Rope($string, $encoding);
    }

    /**
     * Escape the provided input for HTML.
     *
     * @param string $string
     *
     * @return string
     */
    public static function esc($string)
    {
        Arguments::contain(Boa::string())->check($string);

        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Set properties of an object by only calling setters of array keys that
     * are set in the input array. Useful for parsing API responses into
     * entities.
     *
     * @param object $object
     * @param array $input
     * @param array $allowed
     */
    public static function callSetters(
        $object,
        array $input,
        array $allowed = null
    ) {
        if ($allowed !== null) {
            $filtered = Arr::only($input, $allowed);
        } else {
            $filtered = $input;
        }

        foreach ($filtered as $key => $value) {
            $setterName = 'set' . Str::studly($key);

            $object->$setterName($value);
        }
    }

    /**
     * Return the first value if the condition is true, otherwise, return the
     * second.
     *
     * @param bool $biased
     * @param mixed|Closure $one
     * @param mixed|Closure $other
     *
     * @return mixed
     */
    public static function firstBias($biased, $one, $other)
    {
        Arguments::contain(Boa::boolean(), Boa::any(), Boa::any())
            ->check($biased, $one, $other);

        if ($biased) {
            return static::value($one);
        }

        return static::value($other);
    }

    /**
     * Return the default value of the given value.
     *
     * @param Closure|mixed $value
     *
     * @return mixed
     */
    public static function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }

    /**
     * Placeholder.
     *
     * @param mixed $value
     * @param int $options
     * @param int $depth
     *
     * @return string
     */
    public static function jsonEncode($value, $options = 0, $depth = 512)
    {
        return json_encode($value, $options, $depth);
    }

    /**
     * Same as foldl but it works from right to left.
     *
     * @param callable $function
     * @param mixed $initial
     * @param array|FoldableInterface $foldable
     *
     * @return mixed
     */
    public static function foldr(callable $function, $initial, $foldable)
    {
        Arguments::contain(Boa::func(), Boa::any(), Boa::foldable())
            ->check($function, $initial, $foldable);

        return ComplexFactory::toFoldable($foldable)
            ->foldr($function, $initial);
    }

    /**
     * Alias of foldr.
     *
     * @param callable $function
     * @param mixed $initial
     * @param array|Traversable $list
     *
     * @return mixed
     */
    public static function reduceRight(callable $function, $initial, $list)
    {
        return static::foldr($function, $initial, $list);
    }

    /**
     * Returns a single item by iterating through the list, successively calling
     * the iterator function and passing it an accumulator value and the current
     * value from the array, and then passing the result to the next call.
     * (From Ramda).
     *
     * @param callable $function
     * @param mixed $initial
     * @param array|Traversable $foldable
     *
     * @throws InvalidArgumentException
     * @return mixed
     */
    public static function foldl(callable $function, $initial, $foldable)
    {
        Arguments::contain(Boa::func(), Boa::any(), Boa::leftFoldable())
            ->check($function, $initial, $foldable);

        return ComplexFactory::toLeftFoldable($foldable)
            ->foldl($function, $initial);
    }

    /**
     * Alias of foldl.
     *
     * @param callable $function
     * @param mixed $initial
     * @param array|Traversable $traversable
     *
     * @return mixed
     */
    public static function reduce(callable $function, $initial, $traversable)
    {
        return static::foldl($function, $initial, $traversable);
    }

    /**
     * Return the input array but with its items reversed.
     *
     * @param array $list
     *
     * @return array
     */
    public static function reverse($list)
    {
        Arguments::contain(Boa::arr())->check($list);

        // TODO: Support Lists, not just arrays.

        return array_reverse($list);
    }

    /**
     * Placeholder.
     *
     * @param mixed $value
     * @param int $options
     * @param int $depth
     *
     * @return mixed
     */
    public static function jsonDecode($value, $options = 0, $depth = 512)
    {
        return json_decode($value, true, $depth, $options);
    }

    /**
     * Call a function on every item in a list and return the resulting list.
     *
     * @param callable $function
     * @param array|Traversable $traversable
     *
     * @return array
     */
    public static function map(callable $function, $traversable)
    {
        Arguments::contain(Boa::func(), Boa::traversable())
            ->check($function, $traversable);

        $aggregation = [];

        foreach ($traversable as $key => $value) {
            $aggregation[$key] = $function($value, $key);
        }

        return $aggregation;
    }

    /**
     * Filter a list by calling a callback on each element.
     *
     * If the callback returns true, then the element will be added to the
     * resulting array. Otherwise, it will be skipped.
     *
     * Also, unlike array_filter, this function preserves indexes.
     *
     * @param callable $function
     * @param array|Traversable $traversable
     *
     * @return array
     */
    public static function filter(callable $function, $traversable)
    {
        Arguments::contain(Boa::func(), Boa::traversable())
            ->check($function, $traversable);

        $aggregation = [];

        foreach ($traversable as $key => $value) {
            if ($function($value, $key)) {
                $aggregation[$key] = $value;
            }
        }

        return $aggregation;
    }

    /**
     * Left-curry the provided function.
     *
     * @param callable $function
     * @param mixed ...$args
     *
     * @return Closure|mixed
     */
    public static function curry(callable $function, ...$args)
    {
        return static::curryArgs($function, $args);
    }

    /**
     * Left-curry the provided function with the provided array of arguments.
     *
     * @param callable $function
     * @param mixed[] $args
     *
     * @return Closure|mixed
     */
    public static function curryArgs(callable $function, $args)
    {
        Arguments::contain(Boa::func(), Boa::arr())->check($function, $args);

        // Counts required parameters.
        $required = function () use ($function, $args) {
            return (new ReflectionFunction($function))
                ->getNumberOfRequiredParameters();
        };

        $isFulfilled = function (callable $function, $args) use ($required) {
            return count($args) >= $required($function);
        };

        if ($isFulfilled($function, $args)) {
            return static::apply($function, $args);
        }

        return function (...$funcArgs) use (
            $function,
            $args,
            $required,
            $isFulfilled
        ) {
            $newArgs = array_merge($args, $funcArgs);

            if ($isFulfilled($function, $newArgs)) {
                return static::apply($function, $newArgs);
            }

            return static::curryArgs($function, $newArgs);
        };
    }

    /**
     * Call the first argument with the remaining arguments.
     *
     * @param callable $function
     * @param mixed ...$args
     *
     * @return mixed
     */
    public static function call(callable $function, ...$args)
    {
        return call_user_func($function, ...$args);
    }

    /**
     * Call a function N times.
     *
     * This covers one of the most frequent case for using for-loops.
     *
     * @param callable $function
     * @param $times
     */
    public static function poll(callable $function, $times)
    {
        Arguments::contain(Boa::func(), Boa::integer())
            ->check($function, $times);

        for ($ii = 0; $ii < $times; $ii++) {
            static::call($function, $ii);
        }
    }

    /**
     * Attempt call the provided function a number of times until it no longer
     * throws an exception.
     *
     * @param callable $function
     * @param integer $attempts
     *
     * @return mixed|null
     * @throws InvalidArgumentException
     */
    public static function retry(callable $function, $attempts)
    {
        Arguments::contain(Boa::func(), Boa::integer())
            ->check($function, $attempts);

        for ($ii = 0; $ii < $attempts; $ii++) {
            try {
                $result = static::call($function, $ii);

                return $result;
            } catch (Exception $e) {
                continue;
            }
        }

        return null;
    }
}
