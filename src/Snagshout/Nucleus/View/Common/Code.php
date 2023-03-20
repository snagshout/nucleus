<?php

namespace Snagshout\Nucleus\View\Common;

use Snagshout\Nucleus\View\Interfaces\RenderableInterface;
use Snagshout\Nucleus\View\Node;

/**
 * Class Code.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\View\Common
 */
class Code extends Node
{
    /**
     * Construct an instance of a Code.
     *
     * @param array $attributes
     * @param RenderableInterface|RenderableInterface[]|string|string[] $content
     */
    public function __construct(
        array $attributes,
              $content
    )
    {
        parent::__construct('code', $attributes, $content, false);
    }
}
