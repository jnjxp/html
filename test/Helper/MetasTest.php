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
 * Metas Test
 *
 * @category Test
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 * @see      PHPUnit_Framework_TestCase
 */
class MetasTest extends AbstractHelperTest
{

    /**
     * helper adds property
     *
     * @return void
     *
     * @access public
     */
    public function testProperty()
    {
        $helper = $this->helper;

        $helper->addProperty('foo', 'bar');

        $expect = '    <meta property="foo" content="bar" />' . PHP_EOL;
        $actual = "$helper";

        $this->assertSame($expect, $actual);
    }

    /**
     * Helper adds OG Property
     *
     * @return void
     *
     * @access public
     */
    public function testOGProperty()
    {
        $helper = $this->helper;

        $helper->addOpenGraphProperty('foo', 'bar');

        $expect = '    <meta property="og:foo" content="bar" />' . PHP_EOL;
        $actual = "$helper";

        $this->assertSame($expect, $actual);
    }

    /**
     * test charset
     *
     * @return void
     *
     * @access public
     */
    public function testCharset()
    {
        $helper = $this->helper;

        // set
        $helper->charset('foo');
        $expect = '    <meta charset="foo" />' . PHP_EOL;
        $actual = "$helper";
        $this->assertSame($expect, $actual);

        // default
        $helper->charset();
        $expect = '    <meta charset="UTF-8" />' . PHP_EOL;
        $actual = "$helper";
        $this->assertSame($expect, $actual);
    }

    /**
     * test compat
     *
     * @return void
     *
     * @access public
     */
    public function testCompat()
    {
        $helper = $this->helper;

        // set
        $helper->compat('foo');
        $expect = '    <meta http-equiv="X-UA-Compatible" content="foo" />'
            . PHP_EOL;
        $actual = "$helper";
        $this->assertSame($expect, $actual);

        // default
        $helper->compat();
        $expect = '    <meta http-equiv="X-UA-Compatible" content="IE=edge" />'
            . PHP_EOL;
        $actual = "$helper";
        $this->assertSame($expect, $actual);
    }

    /**
     * test description
     *
     * @return void
     *
     * @access public
     */
    public function testDescription()
    {
        $helper = $this->helper;

        // set
        $helper->description('foo');
        $expect = '    <meta name="description" property="og:description" '
            . 'content="foo" />'
            . PHP_EOL;
        $actual = "$helper";
        $this->assertSame($expect, $actual);
    }

    /**
     * test loc
     *
     * @return void
     *
     * @access public
     */
    public function testLoc()
    {
        $helper = $this->helper;

        // set
        $helper->loc('foo');
        $expect = '    <meta property="og:locale" content="foo" />'
            . PHP_EOL;
        $actual = "$helper";
        $this->assertSame($expect, $actual);

        // default
        $helper->loc();
        $expect = '    <meta property="og:locale" content="en_US" />'
            . PHP_EOL;
        $actual = "$helper";
        $this->assertSame($expect, $actual);
    }

    /**
     * test robots
     *
     * @return void
     *
     * @access public
     */
    public function testRobots()
    {
        $helper = $this->helper;

        // set
        $helper->robots('foo');
        $expect = '    <meta name="robots" content="foo" />'
            . PHP_EOL;
        $actual = "$helper";
        $this->assertSame($expect, $actual);

        // default
        $helper->robots();
        $expect = '    <meta name="robots" content="index, follow" />'
            . PHP_EOL;
        $actual = "$helper";
        $this->assertSame($expect, $actual);
    }

    /**
     * test url
     *
     * @return void
     *
     * @access public
     */
    public function testUrl()
    {
        $helper = $this->helper;

        // set
        $helper->url('foo');
        $expect = '    <meta property="og:url" content="foo" />'
            . PHP_EOL;
        $actual = "$helper";
        $this->assertSame($expect, $actual);
    }

    /**
     * test viewport
     *
     * @return void
     *
     * @access public
     */
    public function testViewport()
    {
        $helper = $this->helper;

        // set
        $helper->viewport('foo');
        $expect = '    <meta name="viewport" content="foo" />'
            . PHP_EOL;
        $actual = "$helper";
        $this->assertSame($expect, $actual);

        // default
        $helper->viewport();
        $expect = '    <meta name="viewport" '
            . 'content="width=device-width, initial-scale=1, user-scalable=no" />'
            . PHP_EOL;
        $actual = "$helper";
        $this->assertSame($expect, $actual);
    }

    /**
     * test image
     *
     * @return void
     *
     * @access public
     */
    public function testImage()
    {
        $helper = $this->helper;

        // set
        $helper->image('foo');
        $expect = '    <meta name="image" property="og:image" content="foo" />'
            . PHP_EOL
            . '    <link rel="image_src" href="foo" />'
            . PHP_EOL;
        $actual = "$helper";
        $this->assertSame($expect, $actual);
    }

}
