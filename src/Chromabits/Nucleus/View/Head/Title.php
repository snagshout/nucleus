<?php

namespace Chromabits\Nucleus\View\Head;

use Chromabits\Nucleus\View\Node;

/**
 * Class Title
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View\Head
 */
class Title extends Node
{
    /**
     * Construct an instance of a Button.
     *
     * @param string[] $attributes
     * @param string|Renderable|string[]|Renderable[] $content
     */
    public function __construct($attributes, $content = '')
    {
        parent::__construct('title', $attributes, $content);
    }
}