<?php

namespace Snagshout\Nucleus\View;

use Snagshout\Nucleus\Foundation\BaseObject;
use Snagshout\Nucleus\Support\Html;
use Snagshout\Nucleus\View\Interfaces\RenderableInterface;
use Snagshout\Nucleus\View\Interfaces\SafeHtmlProducerInterface;

/**
 * Class BaseHtmlRenderable
 *
 * A base renderable class containing a basic implementation of getBaseHtml.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\View
 */
abstract class BaseHtmlRenderable extends BaseObject implements
    RenderableInterface,
    SafeHtmlProducerInterface
{
    /**
     * Get a safe HTML version of the contents of this object.
     *
     * @return SafeHtmlWrapper
     */
    public function getSafeHtml()
    {
        $result = $this->render();

        return Html::safe(Html::escape($result));
    }
}
