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
 * Create a bread crumb navigation
 *
 * see http://schema.org/BreadcrumbList
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
     * base attributes
     *
     * see http://schema.org/BreadcrumbList
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
     * user set attributes for breadcrumb
     *
     * @var array
     * @access protected
     */
    protected $attr = [];

    /**
     * bread crumb items
     *
     * @var array
     * @access protected
     */
    protected $stack = [];

    /**
     * html output
     *
     * @var string
     * @access protected
     */
    protected $html = '';

    /**
     * set attributes for breadcrumb
     *
     * @param null|array $attr attributes
     *
     * @return Breadcrumb
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
     * print breadcrumb
     *
     * @return string
     *
     * @access public
     */
    public function __toString()
    {
        if (empty($this->stack)) {
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
     * build an item
     *
     * @param int   $position numeric position
     * @param array $item     array representation of item
     *
     * @return void
     *
     * @access protected
     */
    protected function buildItem($position, array $item)
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
     * build the active item
     *
     * @param array $active array representation of item
     *
     * @return void
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
     * add an item
     *
     * @param string $title  text for item
     * @param string $uri    uri for item
     * @param array  $liAttr attributes for li element
     *
     * @return Breadcrumb
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
     * add a raw item
     *
     * @param string $title  title of item
     * @param string $uri    uri of item
     * @param mixed  $liAttr attributes for li element
     *
     * @return Breadcrumb
     *
     * @access public
     */
    public function rawItem($title, $uri = '#', $liAttr = [])
    {
        $this->stack[] = [$title, ['href' => $uri], $liAttr];
        return $this;
    }

    /**
     * add an array of items
     *
     * @param array $items array of items
     *
     * @return Breadcrumb
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
     * add an array of raw items
     *
     * @param array $items array of raw items to add
     *
     * @return Breadcrumb
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
     * fixes item data
     *
     * @param mixed $uri   uri of item or numeric key
     * @param mixed $title title of item or array of title and li attrs
     *
     * @return array
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
