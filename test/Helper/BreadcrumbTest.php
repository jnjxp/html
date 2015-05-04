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
* @category  Test
* @package   Jnjxp\Html
* @author    Jake Johns <jake@jakejohns.net>
* @copyright 2015 Jake Johns
* @license   http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
* @link      http://jakejohns.net
 */

namespace JnjxpTest\Html\Helper;

/**
 * Breadcrumb Test
 *
 * @category Test
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 * @see      PHPUnit_Framework_TestCase
 */
class BreadcrumbTest extends AbstractHelperTest
{

    /**
     * helper should return empty string if no stack
     *
     * @return void
     *
     * @access public
     */
    public function testEmpty()
    {
        $helper = $this->helper;
        $helper(['id' => 'foo']);
        $actual = "$helper";
        $expect = '';
        $this->assertSame($expect, $actual);
    }

    /**
     * test with escaping
     *
     * @return void
     *
     * @access public
     */
    public function test()
    {
        $helper = $this->helper;
        $helper(['id' => 'foo']);
        $helper->item('&Foo', '/foo')
            ->item('&Bar', '/foo/bar');

        $actual = "$helper";
        $expect ='<nav aria-label="breadcrumb" role="navigation">' . PHP_EOL
            . '    <ol id="foo" itemscope class="breadcrumb" '
            . 'itemtype="http://schema.org/BreadcrumbList">'
            . PHP_EOL
            . '        <li itemscope itemprop="itemListElement" '
            . 'itemtype="http://schema.org/ListItem">'
            . PHP_EOL
            . '            <a href="/foo" itemprop="item">'
            . '<span itemprop="name">&amp;Foo</span></a>'
            . PHP_EOL
            . '            <meta itemprop="position" content="1" />'
            . PHP_EOL
            . '        </li>'
            . PHP_EOL
            . '        <li class="active" itemscope itemprop="itemListElement" '
            . 'itemtype="http://schema.org/ListItem">'
            . PHP_EOL
            . '            <a href="/foo/bar" itemprop="item"><span '
            . 'itemprop="name">&amp;Bar</span></a>'
            . PHP_EOL
            . '            <meta itemprop="position" content="2" />'
            . PHP_EOL
            . '        </li>'
            . PHP_EOL
            . '    </ol>'
            . PHP_EOL
            . '</nav>'
            . PHP_EOL
            ;

        $this->assertSame($expect, $actual);

        $helper(['id' => 'foo'])
            ->items(
                [
                    '/foo' => '&Foo',
                    '/foo/bar' => '&Bar'
                ]
            );
        $actual = "$helper";

        $this->assertSame($expect, $actual);
    }


    /**
     * test raw
     *
     * @return void
     *
     * @access public
     */
    public function testRaw()
    {
        $helper = $this->helper;
        $helper(['id' => 'foo']);
        $helper->rawItem('<i>Foo</i>', '/foo')
            ->rawItem('<i>Bar</i>', '#', ['class' => 'c']);

        $actual = "$helper";
        $expect ='<nav aria-label="breadcrumb" role="navigation">' . PHP_EOL
            . '    <ol id="foo" itemscope class="breadcrumb" '
            . 'itemtype="http://schema.org/BreadcrumbList">'
            . PHP_EOL
            . '        <li itemscope itemprop="itemListElement" '
            . 'itemtype="http://schema.org/ListItem">'
            . PHP_EOL
            . '            <a href="/foo" itemprop="item">'
            . '<span itemprop="name"><i>Foo</i></span></a>'
            . PHP_EOL
            . '            <meta itemprop="position" content="1" />'
            . PHP_EOL
            . '        </li>'
            . PHP_EOL
            . '        <li class="c active" itemscope itemprop="itemListElement" '
            . 'itemtype="http://schema.org/ListItem">'
            . PHP_EOL
            . '            <a href="#" itemprop="item"><span '
            . 'itemprop="name"><i>Bar</i></span></a>'
            . PHP_EOL
            . '            <meta itemprop="position" content="2" />'
            . PHP_EOL
            . '        </li>'
            . PHP_EOL
            . '    </ol>'
            . PHP_EOL
            . '</nav>'
            . PHP_EOL
            ;

        $this->assertSame($expect, $actual);

        $helper(['id' => 'foo'])
            ->rawItems(
                [
                    '/foo' => '<i>Foo</i>',
                    ['<i>Bar</i>', 'class' => 'c']
                ]
            );
        $actual = "$helper";

        $this->assertSame($expect, $actual);
    }


}
