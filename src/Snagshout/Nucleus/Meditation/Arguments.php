<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Snagshout\Nucleus\Meditation;

use Snagshout\Nucleus\Foundation\BaseObject;
use Snagshout\Nucleus\Meditation\Constraints\AbstractConstraint;
use Snagshout\Nucleus\Meditation\Exceptions\InvalidArgumentException;

/**
 * Class Arguments.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Meditation
 */
class Arguments extends BaseObject
{
    /**
     * Constraints for the checker.
     *
     * @var AbstractConstraint[]
     */
    protected $constraints;

    /**
     * Construct an instance of an Arguments.
     *
     * @param AbstractConstraint[] ...$constraints
     */
    public function __construct(...$constraints)
    {
        parent::__construct();

        $this->constraints = $constraints;
    }

    /**
     * Construct an instance of an Argument.
     *
     * @param AbstractConstraint[] $constraints
     *
     * @return static
     * @deprecated See Arguments::define
     */
    public static function contain(...$constraints)
    {
        return new static(...$constraints);
    }

    /**
     * Construct an instance of an Argument.
     *
     * @param AbstractConstraint[] $constraints
     *
     * @return static
     */
    public static function define(...$constraints)
    {
        return new static(...$constraints);
    }

    /**
     * Check that the parameters are met.
     *
     * @param AbstractConstraint[] ...$args
     *
     * @throws InvalidArgumentException
     */
    public function check(...$args)
    {
        if (count($args) !== count($this->constraints)) {
            throw new InvalidArgumentException(
                'Argument number mismatch.'
            );
        }

        foreach ($args as $key => $arg) {
            if (!$this->constraints[$key]->check($arg, $args)) {
                throw new InvalidArgumentException(vsprintf(
                    'Argument %s does not meet its constraints.'
                    . "\nFailed constraint: %s\nValue provided:%s",
                    [
                        $key,
                        $this->constraints[$key]->toString(),
                        print_r($arg, true)
                    ]
                ));
            }
        }
    }
}
