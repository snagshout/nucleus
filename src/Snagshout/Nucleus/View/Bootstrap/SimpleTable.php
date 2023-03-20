<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Snagshout\Nucleus\View\Bootstrap;

use Snagshout\Nucleus\Support\Html;
use Snagshout\Nucleus\Support\Std;
use Snagshout\Nucleus\View\Common\Table;
use Snagshout\Nucleus\View\Common\TableBody;
use Snagshout\Nucleus\View\Common\TableCell;
use Snagshout\Nucleus\View\Common\TableHeader;
use Snagshout\Nucleus\View\Common\TableHeaderCell;
use Snagshout\Nucleus\View\Common\TableRow;
use Snagshout\Nucleus\View\Interfaces\RenderableInterface;
use Snagshout\Nucleus\View\Interfaces\SafeHtmlProducerInterface;
use Snagshout\Nucleus\View\SafeHtmlWrapper;

/**
 * Class SimpleTable.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Snagshout\Nucleus\View\Bootstrap
 */
class SimpleTable implements RenderableInterface, SafeHtmlProducerInterface
{
    /**
     * @var string[]
     */
    protected $headerLabels;

    /**
     * @var string[][]
     */
    protected $rows;

    /**
     * Construct an instance of a SimpleTable.
     *
     * @param string[] $headerLabels
     * @param string[][] $rows
     */
    public function __construct(array $headerLabels, array $rows)
    {
        $this->headerLabels = $headerLabels;
        $this->rows = $rows;
    }

    /**
     * Render the object into a string.
     *
     * @return mixed
     */
    public function render()
    {
        return (new Table(['class' => 'table'], [
            new TableHeader([], new TableRow([], Std::map(
                function ($columnLabel) {
                    return new TableHeaderCell([], $columnLabel);
                },
                $this->headerLabels
            ))),
            new TableBody([], Std::map(function ($row) {
                return new TableRow([], Std::map(function ($cell) {
                    return new TableCell([], $cell);
                }, $row));
            }, $this->rows)),
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
