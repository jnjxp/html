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
 * Scripts Test
 *
 * @category Test
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 * @see      PHPUnit_Framework_TestCase
 */
class ScriptsTest extends AbstractHelperTest
{
    /**
     * tests helper adds inline script
     *
     * @return void
     *
     * @access public
     */
    public function testAddInline()
    {
        $helper = $this->helper;
        $helper->addInline("foo");
        $expect = '    <script type="text/javascript">foo</script>' . PHP_EOL;
        $actual = "$helper";

        $this->assertSame($expect, $actual);
    }

    /**
     * adds an event listener
     *
     * @return void
     *
     * @access public
     */
    public function testAddEventListener()
    {
        $helper = $this->helper;

        // func only
        $helper->addEventListener('foo');
        $expect = '    <script type="text/javascript">'
            . 'document.addEventListener("DOMContentLoaded", foo);'
            . '</script>'
            . PHP_EOL;
        $actual = "$helper";

        $this->assertSame($expect, $actual);

        // w/ event
        $helper->addEventListener('foo', 'event');
        $expect = '    <script type="text/javascript">'
            . 'document.addEventListener("event", foo);'
            . '</script>'
            . PHP_EOL;
        $actual = "$helper";

        $this->assertSame($expect, $actual);

        // w/ node
        $helper->addEventListener('foo', 'event', 'ele');
        $expect = '    <script type="text/javascript">'
            . 'ele.addEventListener("event", foo);'
            . '</script>'
            . PHP_EOL;
        $actual = "$helper";

        $this->assertSame($expect, $actual);

        // w/ wrap
        $helper->addEventListener('foo', 'event', 'ele', true);
        $expect = '    <script type="text/javascript">'
            . 'ele.addEventListener("event", function(event) { foo });'
            . '</script>'
            . PHP_EOL;
        $actual = "$helper";

        $this->assertSame($expect, $actual);
    }

    /**
     * helper captures inline script
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
        $helper->captureEnd();

        $expect = '    <script type="text/javascript">foo</script>' . PHP_EOL;
        $actual = "$helper";

        $this->assertSame($expect, $actual);
    }

    /**
     * helper captures event
     *
     * @return mixed
     *
     * @access public
     */
    public function testEventCapture()
    {
        $helper = $this->helper;

        // func only
        $helper->eventCaptureStart();
        echo 'foo';
        $helper->captureEnd();

        $expect = '    <script type="text/javascript">'
            . 'document.addEventListener("DOMContentLoaded", foo);'
            . '</script>'
            . PHP_EOL;
        $actual = "$helper";

        $this->assertSame($expect, $actual);


        // w/ event
        $helper->eventCaptureStart('event');
        echo 'foo';
        $helper->captureEnd();

        $expect = '    <script type="text/javascript">'
            . 'document.addEventListener("event", foo);'
            . '</script>'
            . PHP_EOL;
        $actual = "$helper";

        $this->assertSame($expect, $actual);

        // w/ node
        $helper->eventCaptureStart('event', 'ele');
        echo 'foo';
        $helper->captureEnd();
        $expect = '    <script type="text/javascript">'
            . 'ele.addEventListener("event", foo);'
            . '</script>'
            . PHP_EOL;
        $actual = "$helper";

        $this->assertSame($expect, $actual);

        // w/ wrap
        $helper->eventCaptureStart('event', 'ele', true);
        echo 'foo';
        $helper->captureEnd();
        $expect = '    <script type="text/javascript">'
            . 'ele.addEventListener("event", function(event) { foo });'
            . '</script>'
            . PHP_EOL;
        $actual = "$helper";

        $this->assertSame($expect, $actual);
    }
}
