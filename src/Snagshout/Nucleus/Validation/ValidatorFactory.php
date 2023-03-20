<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Snagshout\Nucleus\Validation;

use Snagshout\Nucleus\Meditation\Arguments;
use Snagshout\Nucleus\Meditation\Boa;
use Snagshout\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use Snagshout\Nucleus\Meditation\SpecFactory;

/**
 * Class ValidatorFactory.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Validation
 */
class ValidatorFactory extends SpecFactory
{
    /**
     * @var array
     */
    protected $messages;

    /**
     * Construct an instance of a ValidatorFactory.
     */
    public function __construct()
    {
        parent::__construct();

        $this->messages = [];
    }

    /**
     * @return static
     */
    public static function define()
    {
        return new static();
    }

    /**
     * Add a custom message for a field.
     *
     * @param $field
     * @param $message
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function message($field, $message)
    {
        Arguments::define(Boa::string(), Boa::string())
            ->check($field, $message);

        $this->messages[$field] = $message;

        return $this;
    }

    /**
     * Build an instance of a Validator.
     *
     * @return Validator
     */
    public function make()
    {
        return new Validator(parent::make(), $this->messages);
    }
}
