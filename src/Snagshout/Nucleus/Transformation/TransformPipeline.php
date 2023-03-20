<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Snagshout\Nucleus\Transformation;

use Closure;
use Snagshout\Nucleus\Foundation\BaseObject;
use Snagshout\Nucleus\Support\Std;
use Snagshout\Nucleus\Transformation\Interfaces\TransformInterface;

/**
 * Class TransformPipeline.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Support
 */
class TransformPipeline extends BaseObject implements TransformInterface
{
    /**
     * @var TransformInterface[]
     */
    protected $transforms;

    /**
     * @return static
     */
    public static function define()
    {
        return new static();
    }

    /**
     * Add a transform to the pipeline.
     *
     * @param TransformInterface $transform
     *
     * @return $this
     */
    public function add(TransformInterface $transform)
    {
        $this->transforms[] = $transform;

        return $this;
    }

    /**
     * Add a transform to the pipeline using the provided closure.
     *
     * @param Closure $transform
     *
     * @return TransformPipeline
     */
    public function inline(Closure $transform)
    {
        return $this->add(new ClosureTransform($transform));
    }

    /**
     * Run the input through the pipeline.
     *
     * @param array $input
     *
     * @return array
     */
    public function run(array $input)
    {
        return Std::foldl(function ($current, TransformInterface $input) {
            return $input->run($current);
        }, $input, $this->transforms);
    }
}
