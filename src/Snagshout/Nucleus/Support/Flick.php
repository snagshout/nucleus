<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Snagshout\Nucleus\Support;

use ArrayAccess;
use Snagshout\Nucleus\Control\Maybe;
use Snagshout\Nucleus\Data\Factories\ComplexFactory;
use Snagshout\Nucleus\Exceptions\LackOfCoffeeException;
use Snagshout\Nucleus\Exceptions\UnknownKeyException;
use Snagshout\Nucleus\Foundation\BaseObject;
use Snagshout\Nucleus\Meditation\Arguments;
use Snagshout\Nucleus\Meditation\Boa;
use Snagshout\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use Traversable;

/**
 * Class Flick.
 *
 * An experiment. It behaves like a switch block.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Support
 */
class Flick extends BaseObject
{
    /**
     * @var array|Traversable|ArrayAccess
     */
    protected $functions;

    /**
     * @var string
     */
    protected $default;

    /**
     * Construct an instance of a Flick.
     *
     * @param array|ArrayAccess|Traversable $functions
     * @param string $default
     *
     * @throws InvalidArgumentException
     * @throws LackOfCoffeeException
     */
    public function __construct($functions, $default = 'default')
    {
        parent::__construct();

        Arguments::define(
            Boa::lst(),
            Boa::either(Boa::string(), Boa::integer())
        )->check($functions, $default);

        $this->functions = $functions;
        $this->default = $default;
    }

    /**
     * Construct an instance of a Flick.
     *
     * @param array|ArrayAccess|Traversable $functions
     * @param string|int $default
     *
     * @return Flick
     */
    public static function when($functions, $default = 'default')
    {
        return new Flick($functions, $default);
    }

    /**
     * Run the flick on input.
     *
     * @param string|int $input
     *
     * @return mixed
     * @throws UnknownKeyException
     */
    public function go($input)
    {
        Arguments::define(Boa::readMap())->define($input);

        $map = ComplexFactory::toReadMap($this->functions);

        if ($map->member($input)) {
            /** @var callable $function */
            $function = Maybe::fromJust($map->lookup($input));

            return $function();
        } elseif ($map->member($this->default)) {
            /** @var callable $function */
            $function = Maybe::fromJust($map->lookup($this->default));

            return $function();
        }

        throw new UnknownKeyException();
    }
}
