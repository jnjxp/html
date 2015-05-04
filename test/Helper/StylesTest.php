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
 * Styles Test
 *
 * @category Test
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 * @see      PHPUnit_Framework_TestCase
 */
class StylesTest extends AbstractHelperTest
{
    /**
     * tests helper adds inline style
     *
     * @return void
     *
     * @access public
     */
    public function testAddInline()
    {
        $helper = $this->helper;
        $helper->addInline("foo");
        $expect = '    <style type="text/css" media="screen">foo</style>' . PHP_EOL;
        $actual = "$helper";

        $this->assertSame($expect, $actual);
    }

    /**
     * tests helper adds inline conditional style
     *
     * @return void
     *
     * @access public
     */
    public function testAddInlineCond()
    {
        $helper = $this->helper;
        $helper->addInlineCond('foo', 'bar');
        $expect = '    <!--[if foo]><style type="text/css" '
            . 'media="screen">bar</style><![endif]-->'
            . PHP_EOL;
        $actual = "$helper";

        $this->assertSame($expect, $actual);
    }

    /**
     * tests helper captures inline style
     *
     * @return void
     *
     * @access public
     */
    public function testInlineCapture()
    {
        $helper = $this->helper;

        $helper->inlineCaptureStart();
        echo 'foo';
        $helper->inlineCaptureEnd();

        $expect = '    <style type="text/css" media="screen">foo</style>' . PHP_EOL;
        $actual = "$helper";

        $this->assertSame($expect, $actual);
    }

    /**
     * tests helper captures inline conditional style
     *
     * @return void
     *
     * @access public
     */
    public function testCondCapture()
    {
        $helper = $this->helper;
        $helper->inlineCondCaptureStart('foo');
        echo 'bar';
        $helper->inlineCaptureEnd();

        $expect = '    <!--[if foo]><style type="text/css" '
            . 'media="screen">bar</style><![endif]-->'
            . PHP_EOL;
        $actual = "$helper";

        $this->assertSame($expect, $actual);
    }
}
