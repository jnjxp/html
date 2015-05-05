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
 * Title Test
 *
 * @category Test
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 * @see      PHPUnit_Framework_TestCase
 */
class TitleTest extends AbstractHelperTest
{

    /**
     * helper sets title
     *
     * @return void
     *
     * @access public
     */
    public function testTitle()
    {
        $helper = $this->helper;
        $helper('foo');
        $actual = "$helper";
        $expect = '    <title>foo</title>'
            . PHP_EOL
            . '    <meta name="title" property="og:title" content="foo" />'
            . PHP_EOL;
        $this->assertSame($expect, $actual);

        // with site
        $helper = $this->helper;
        $helper('foo');
        $helper->setSite('BAR');
        $actual = "$helper";
        $expect = '    <title>foo</title>'
            . PHP_EOL
            . '    <meta name="title" property="og:title" content="foo" />'
            . PHP_EOL
            . '    <meta property="og:site_name" content="BAR" />'
            . PHP_EOL;
        $this->assertSame($expect, $actual);
    }
}
