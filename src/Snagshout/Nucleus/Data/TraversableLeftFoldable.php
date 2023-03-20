<?php

namespace Snagshout\Nucleus\Data;

use Closure;
use Snagshout\Nucleus\Control\Maybe;
use Snagshout\Nucleus\Data\Interfaces\LeftFoldableInterface;
use Snagshout\Nucleus\Data\Interfaces\ReadMapInterface;
use Snagshout\Nucleus\Exceptions\CoreException;
use Snagshout\Nucleus\Foundation\BaseObject;
use Snagshout\Nucleus\Support\Std;
use Traversable;

/**
 * Class TraversableMap
 *
 * A Map backed by a Traversable object.
 *
 * Warning: At the moment, ReadMap operations on this object are not optimal.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Data
 */
class TraversableLeftFoldable extends BaseObject implements
    LeftFoldableInterface, ReadMapInterface
{
    /**
     * @var TraversableLeftFoldable
     */
    protected $value;

    /**
     * Construct an instance of a TraversableLeftFoldable.
     *
     * @param Traversable $input
     */
    public function __construct(Traversable $input)
    {
        parent::__construct();

        $this->value = $input;
    }

    /**
     * Combine all the elements in the traversable using a combining operation.
     *
     * @param callable|Closure $closure
     * @param mixed $initial
     *
     * @return mixed
     */
    public function foldl(callable $closure, $initial)
    {
        $accumulator = $initial;

        foreach ($this->value as $value) {
            $accumulator = Std::call($closure, $accumulator, $value);
        }

        return $accumulator;
    }

    /**
     * Combine all the elements in the traversable using a combining operation.
     *
     * @param callable|Closure $closure
     * @param mixed $initial
     *
     * @return mixed
     */
    public function foldlWithKey(callable $closure, $initial)
    {
        $accumulator = $initial;

        foreach ($this->value as $key => $value) {
            $accumulator = Std::call($closure, $accumulator, $value, $key);
        }

        return $accumulator;
    }

    /**
     * Get the value of the provided key.
     *
     * @param string $key
     *
     * @return Maybe
     * @throws CoreException
     */
    public function lookup($key)
    {
        foreach ($this->value as $innerKey => $value) {
            if ($key === $innerKey) {
                return Maybe::just($value);
            }
        }

        return Maybe::nothing();
    }

    /**
     * Return whether or not the map contains the specified key.
     *
     * @param string $key
     *
     * @return bool
     */
    public function member($key)
    {
        foreach ($this->value as $innerKey => $value) {
            if ($key === $innerKey) {
                return true;
            }
        }

        return false;
    }
}
