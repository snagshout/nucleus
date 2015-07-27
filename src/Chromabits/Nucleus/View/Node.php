<?php

namespace Chromabits\Nucleus\View;

use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Meditation\Spec;
use Chromabits\Nucleus\View\Exceptions\InvalidAttributesException;
use Chromabits\Nucleus\View\Interfaces\Renderable;

/**
 * Class Node
 *
 * WIP
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View
 */
class Node implements Renderable
{
    protected $tagName = null;

    protected $attributes = [];

    protected $selfClosing = false;

    protected $content;

    protected $spec;

    /**
     * Construct an instance of a Node.
     *
     * @param string $tagName
     * @param string[] $attributes
     * @param string|Renderable|string[]|Renderable[] $content
     * @param bool $selfClosing
     */
    public function __construct(
        $tagName,
        $attributes,
        $content,
        $selfClosing = false
    ) {
        $this->tagName = $tagName;
        $this->attributes = $attributes;
        $this->content = $content;
        $this->selfClosing = $selfClosing;

        $this->spec = new Spec();
    }

    /**
     * Render a single attribute in a node.
     *
     * @param string $name
     * @param null|string $value
     *
     * @return string
     */
    protected function renderAttribute($name, $value = null)
    {
        if ($value === null) {
            return $name;
        }

        return vsprintf('%s="%s"', [
            $name,
            nucleus_escape_html((string) $value)
        ]);
    }

    /**
     * Render the attributes part of the opening tag.
     *
     * @return string
     */
    protected function renderAttributes()
    {
        return implode(' ', array_map(function ($name, $value) {
            return $this->renderAttribute($name, $value);
        }, array_keys($this->attributes), $this->attributes));
    }

    /**
     * Render the content of the tag.
     *
     * @return string
     * @throws CoreException
     */
    protected function renderContent()
    {
        if (is_string($this->content)) {
            return nucleus_escape_html($this->content);
        } elseif ($this->content instanceof Renderable) {
            return $this->content->render();
        } elseif (is_array($this->content)) {
            return implode('', array_map(function ($child) {
                if (is_string($child)) {
                    return nucleus_escape_html($child);
                } elseif ($child instanceof Renderable) {
                    return $child->render();
                }

                throw new CoreException(
                    'Unknown content type. Child item cannot be rendered.'
                );
            }, $this->content));
        }

        throw new CoreException(
            'Unknown content type. Node cannot be rendered.'
        );
    }

    /**
     * Render the Node.
     *
     * @return string
     * @throws CoreException
     * @throws InvalidAttributesException
     */
    public function render()
    {
        $result = $this->spec->check($this->attributes);
        if ($result->failed()) {
            throw new InvalidAttributesException($result);
        }

        if ($this->selfClosing) {
            return sprintf(
                '<%s%s/>',
                [$this->tagName, $this->renderAttributes()]
            );
        }

        $attributes = $this->renderAttributes();
        if (strlen($attributes)) {
            $attributes = ' ' . $attributes;
        }

        return vsprintf(
            '<%s%s>%s</%s>',
            [
                $this->tagName,
                $attributes,
                $this->renderContent(),
                $this->tagName
            ]
        );
    }
}