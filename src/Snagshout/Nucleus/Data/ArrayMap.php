<?php

namespace Snagshout\Nucleus\Data;

use ArrayObject;
use Snagshout\Nucleus\Control\Interfaces\ApplicativeInterface;
use Snagshout\Nucleus\Control\Maybe;
use Snagshout\Nucleus\Data\Interfaces\IterableInterface;
use Snagshout\Nucleus\Data\Interfaces\KeyFoldableInterface;
use Snagshout\Nucleus\Data\Interfaces\LeftKeyFoldableInterface;
use Snagshout\Nucleus\Data\Interfaces\ListInterface;
use Snagshout\Nucleus\Data\Interfaces\MapInterface;
use Snagshout\Nucleus\Data\Interfaces\MappableInterface;
use Snagshout\Nucleus\Data\Interfaces\MonoidInterface;
use Snagshout\Nucleus\Data\Interfaces\SemigroupInterface;
use Snagshout\Nucleus\Data\Traits\ArrayBackingTrait;
use Snagshout\Nucleus\Exceptions\CoreException;
use Snagshout\Nucleus\Foundation\Interfaces\ArrayableInterface;
use Snagshout\Nucleus\Meditation\Boa;
use Snagshout\Nucleus\Meditation\Constraints\AbstractTypeConstraint;
use Snagshout\Nucleus\Meditation\Exceptions\MismatchedArgumentTypesException;

/**
 * Class ArrayMap.
 *
 * @method map(callable $callable): ArrayMap|Iterable
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Data
 */
class ArrayMap extends KeyedCollection implements
    MapInterface,
    MonoidInterface,
    ApplicativeInterface,
    MappableInterface,
    ListInterface,
    KeyFoldableInterface,
    LeftKeyFoldableInterface
{
    use ArrayBackingTrait;

    /**
     * @param mixed $input
     *
     * @return ArrayMap|static
     */
    public static function of($input)
    {
        if ($input instanceof static) {
            return $input;
        } elseif ($input instanceof ArrayableInterface) {
            return new static($input->toArray());
        }

        return new static($input);
    }

    /**
     * @var array
     */
    protected $value;

    /**
     * Construct an instance of a ArrayMap.
     *
     * @param array|ArrayObject $value
     */
    public function __construct($value = [])
    {
        parent::__construct();

        if ($value instanceof ArrayObject) {
            $value = $value->getArrayCopy();
        }

        $this->value = $value;
        $this->size = count($value);
    }

    /**
     * @return AbstractTypeConstraint
     */
    public function getKeyType()
    {
        // TODO: Figure out how to make this nicer.
        return Boa::any();
    }

    /**
     * @return AbstractTypeConstraint
     */
    public function getValueType()
    {
        // TODO: Figure out how to make this nicer.
        return Boa::any();
    }

    /**
     * @param mixed $key
     *
     * @return Maybe
     */
    public function lookup($key)
    {
        if ($this->member($key) === false) {
            return Maybe::nothing();
        }

        $copy = array_merge($this->value);

        return Maybe::just($copy[$key]);
    }

    /**
     * @param callable $callable
     *
     * @return IterableInterface
     */
    public function filter(callable $callable)
    {
        $result = [];

        foreach ($this->value as $key => $value) {
            if ($callable($value, $key, $this)) {
                $result[$key] = $value;
            }
        }

        return static::of($result);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->value;
    }

    /**
     * @return IterableInterface
     */
    public function reverse()
    {
        return new static(array_reverse($this->value, true));
    }

    /**
     * @return ListInterface
     */
    public function toList()
    {
        return $this->values();
    }

    /**
     * @return MapInterface
     */
    public function toMap()
    {
        return $this;
    }

    /**
     * Append another semigroup and return the result.
     *
     * @param ArrayMap|SemigroupInterface $other
     *
     * @return ArrayMap|SemigroupInterface
     * @throws CoreException
     * @throws MismatchedArgumentTypesException
     */
    public function append(SemigroupInterface $other)
    {
        if ($other instanceof static) {
            return new static(array_merge($this->value, $other->value));
        }

        $this->throwMismatchedDataTypeException($other);
    }
}
