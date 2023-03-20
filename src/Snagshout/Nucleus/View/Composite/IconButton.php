<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Snagshout\Nucleus\View\Composite;

use Snagshout\Nucleus\Support\Html;
use Snagshout\Nucleus\View\Common\Button;
use Snagshout\Nucleus\View\Common\Italic;
use Snagshout\Nucleus\View\Interfaces\RenderableInterface;
use Snagshout\Nucleus\View\Interfaces\SafeHtmlProducerInterface;
use Snagshout\Nucleus\View\SafeHtmlWrapper;

/**
 * Class IconButton.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\View\Composite
 */
class IconButton implements RenderableInterface, SafeHtmlProducerInterface
{
    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var RenderableInterface|RenderableInterface[]|string|string[]
     */
    protected $content;

    /**
     * @var string
     */
    protected $icon;

    /**
     * @param string $icon
     * @param string|RenderableInterface|string[]|RenderableInterface[] $content
     * @param array $attributes
     */
    public function __construct($icon, $content = '', $attributes = [])
    {
        $this->icon = $icon;
        $this->content = $content;
        $this->attributes = $attributes;
    }

    /**
     * Render the object into a string.
     *
     * @return mixed
     */
    public function render()
    {
        return (new Button($this->attributes, [
            new Italic(['class' => 'icon ' . $this->icon]),
            $this->content,
        ]))->render();
    }

    /**
     * Get a safe HTML version of the contents of this object.
     *
     * @return SafeHtmlWrapper
     */
    public function getSafeHtml()
    {
        return Html::safe($this->render());
    }
}
