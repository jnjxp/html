<?php
/**
* Jnjxp\Html
*
* PHP version 5
*
* This program is free software: you can redistribute it and/or modify it
* under the terms of the GNU Affero General Public License as published by
* the Free Software Foundation, either version 3 of the License, or (at your
* option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @category  Helper
* @package   Jnjxp\Html
* @author    Jake Johns <jake@jakejohns.net>
* @copyright 2015 Jake Johns
* @license   http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
* @link      http://jakejohns.net
 */

namespace Jnjxp\Html\Helper;

use Aura\Html\Helper\AbstractHelper;

/**
 * Title
 *
 * @category Helper
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
class Breadcrumb extends AbstractHelper
{
    /**
     * baseAttr
     *
     * @var mixed
     * @access protected
     */
    protected $baseAttr = [
        'nav' => [
            'aria-label' => 'breadcrumb',
            'role'       => 'navigation'
        ],
        'ol' => [
            'itemscope' => true,
            'class'     => ['breadcrumb'],
            'itemtype'  => 'http://schema.org/BreadcrumbList',
        ],
        'li' => [
            'itemscope' => true,
            'itemprop'  => 'itemListElement',
            'itemtype'  => 'http://schema.org/ListItem',
        ],
        'a' => [
            'itemprop' => 'item'
        ],
        'span' => [
            'itemprop' => 'name'
        ],
        'meta' => [
            'itemprop' => 'position',
            'content'  => null
        ]
    ];

    /**
     * attr
     *
     * @var mixed
     * @access protected
     */
    protected $attr = [];

    /**
     * stack
     *
     * @var mixed
     * @access protected
     */
    protected $stack = [];

    /**
     * html
     *
     * @var string
     * @access protected
     */
    protected $html = '';

    /**
     * __invoke
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param array $attr DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function __invoke(array $attr = null)
    {
        if ($attr) {
            $this->attr = $attr;
        }
        return $this;
    }

    /**
     * __toString
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function __toString()
    {
        if (! $this->stack) {
            return '';
        }

        $base = $this->baseAttr;
        $esc  = $this->escaper->attr;

        $active = array_pop($this->stack);

        $navAttr  = $esc($base['nav']);
        $listAttr = $esc(array_merge_recursive($this->attr, $base['ol']));

        $this->html = $this->indent(0, "<nav {$navAttr}>");
        $this->html .= $this->indent(1, "<ol {$listAttr}>");

        foreach ($this->stack as $position => $item) {
            $this->buildItem($position, $item);
        }

        $this->buildActive($active);

        $this->html .= $this->indent(1, '</ol>');
        $this->html .= $this->indent(0, '</nav>');


        $html = $this->html;

        $this->attr  = [];
        $this->stack = [];
        $this->html  = '';

        return $html;
    }

    /**
     * buildItem
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $position DESCRIPTION
     * @param mixed $item     DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access protected
     */
    protected function buildItem($position, $item)
    {
        $position +=1;

        list($title, $aAttr, $liAttr) = $item;

        $base = $this->baseAttr;
        $esc  = $this->escaper->attr;

        $meta = $base['meta'];
        $meta['content'] = $position;


        $liAttr   = $esc(array_merge_recursive($liAttr, $base['li']));
        $aAttr    = $esc(array_merge_recursive($aAttr, $base['a']));
        $spanAttr = $esc($base['span']);

        $title  = "<span $spanAttr>$title</span>";
        $anchor = "<a $aAttr>$title</a>";
        $meta   = $this->void('meta', $meta);

        $this->html .= $this->indent(2, "<li {$liAttr}>");
        $this->html .= $this->indent(3, $anchor);
        $this->html .= $this->indent(3, $meta);
        $this->html .= $this->indent(2, '</li>');
    }

    /**
     * buildActive
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param array $active DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access protected
     */
    protected function buildActive(array $active)
    {
        $active[2] = array_merge_recursive(
            $active[2],
            ['class' => 'active']
        );
        $this->buildItem(count($this->stack), $active);
    }


    /**
     * addItem
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed  $title  DESCRIPTION
     * @param string $uri    DESCRIPTION
     * @param array  $liAttr DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function item($title, $uri = '#', $liAttr = [])
    {
        $this->stack[] = [
            $this->escaper->html($title),
            ['href' => $uri],
            $liAttr,
        ];
        return $this;
    }

    /**
     * item
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed  $title  DESCRIPTION
     * @param string $uri    DESCRIPTION
     * @param mixed  $liAttr DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function rawItem($title, $uri = '#', $liAttr = [])
    {
        $this->stack[] = [$title, ['href' => $uri], $liAttr];
        return $this;
    }

    /**
     * items
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param array $items DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function items(array $items)
    {
        foreach ($items as $uri => $title) {
            list($title, $uri, $liAttr) = $this->fixData($uri, $title);
            $this->item($title, $uri, $liAttr);
        }
        return $this;
    }

    /**
     * rawItems
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param array $items DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function rawItems(array $items)
    {
        foreach ($items as $uri => $title) {
            list($title, $uri, $liAttr) = $this->fixData($uri, $title);
            $this->rawItem($title, $uri, $liAttr);
        }
        return $this;
    }

    /**
     * fixData
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $uri   DESCRIPTION
     * @param mixed $title DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access protected
     */
    protected function fixData($uri, $title)
    {
        $liAttr = [];
        if (is_int($uri)) {
            $uri = '#';
        }
        if (is_array($title)) {
            $liAttr = $title;
            $title = array_shift($liAttr);
        }
        return [$title, $uri, $liAttr];
    }
}
