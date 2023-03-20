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

use Snagshout\Nucleus\Exceptions\CoreException;
use Snagshout\Nucleus\Foundation\StaticObject;
use Snagshout\Nucleus\Meditation\Arguments;
use Snagshout\Nucleus\Meditation\Boa;
use Snagshout\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use Snagshout\Nucleus\Meditation\TypeHound;
use Snagshout\Nucleus\View\Interfaces\SafeHtmlProducerInterface;
use Snagshout\Nucleus\View\SafeHtmlWrapper;

/**
 * Class Html.
 *
 * Utilities for manipulating HTML.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\Support
 */
class Html extends StaticObject
{
    /**
     * Escape the provided string.
     *
     * @param SafeHtmlWrapper|SafeHtmlProducerInterface|string $string
     *
     * @return SafeHtmlWrapper|string
     * @throws InvalidArgumentException
     * @throws CoreException
     */
    public static function escape($string)
    {
        Arguments::define(
            Boa::either(
                Boa::either(
                    Boa::instance(SafeHtmlWrapper::class),
                    Boa::instance(SafeHtmlProducerInterface::class)
                ),
                Boa::string()
            )
        )->check($string);

        if ($string instanceof SafeHtmlWrapper) {
            return $string;
        } elseif ($string instanceof SafeHtmlProducerInterface) {
            $result = $string->getSafeHtml();

            if ($result instanceof SafeHtmlWrapper) {
                return $result;
            } elseif ($result instanceof SafeHtmlProducerInterface) {
                return static::escape($result);
            }

            throw new CoreException(vsprintf(
                'Object of class %s implements SafeHtmlProducerInterface'
                . ' but it returned an unsafe type: %s',
                [get_class($string), TypeHound::fetch($result)]
            ));
        }

        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Mark a string as safe HTML.
     *
     * @param string|SafeHtmlWrapper $string
     *
     * @return SafeHtmlWrapper
     */
    public static function safe($string)
    {
        if ($string instanceof SafeHtmlWrapper) {
            return $string;
        }

        return new SafeHtmlWrapper($string);
    }
}
