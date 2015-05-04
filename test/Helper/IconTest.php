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
 * Icon Test
 *
 * @category Test
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 * @see      PHPUnit_Framework_TestCase
 */
class IconTest extends AbstractHelperTest
{

    /**
     * helper return html for a simple icon
     *
     * @return void
     *
     * @access public
     */
    public function testPlain()
    {
        $helper = $this->helper;
        $expect = '<span class="icon icon-foo" aria-hidden="true"><!-- --></span>';
        $actual = $helper('foo');
        $this->assertSame($expect, $actual);
    }

    /**
     * helper returns icon with text for screen reader
     *
     * @return void
     *
     * @access public
     */
    public function testAlt()
    {
        $helper = $this->helper;
        $expect = '<span class="icon icon-foo" aria-hidden="true"><!-- --></span>'
            . ' <span class="sr-only">bar</span>';
        $actual = $helper('foo', 'bar');
        $this->assertSame($expect, $actual);
    }

    /**
     * helper returns icon with text for screen reader based on icon name
     *
     * @return void
     *
     * @access public
     */
    public function testSimpleAlt()
    {
        $helper = $this->helper;
        $expect = '<span class="icon icon-foo" aria-hidden="true"><!-- --></span>'
            . ' <span class="sr-only">foo</span>';
        $actual = $helper('foo', true);
        $this->assertSame($expect, $actual);
    }
}
