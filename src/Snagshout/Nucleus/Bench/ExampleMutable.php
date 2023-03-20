<?php

namespace Snagshout\Nucleus\Bench;

use Snagshout\Nucleus\Foundation\BaseObject;

/**
 * Class ExampleMutable.
 *
 * @internal
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Bench
 */
class ExampleMutable extends BaseObject
{
    /**
     * @var array
     */
    protected $value;

    /**
     * Construct an instance of a ExampleMutable.
     */
    public function __construct()
    {
        parent::__construct();

        $this->value = [];
    }

    /**
     * Perform a mutation.
     */
    public function mutate()
    {
        $this->value[] = 45;

        return $this;
    }
}
