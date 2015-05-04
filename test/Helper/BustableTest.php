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
 * Bustable Test
 *
 * @category Test
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 * @see      PHPUnit_Framework_TestCase
 * @abstract
 */
class BustableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * instance of helper being tested
     *
     * @var \JnjxpTest\Html\MockBustable
     * @access protected
     */
    protected $helper;

    /**
     * fake public root
     *
     * @var string
     * @access protected
     */
    protected $public;

    /**
     * set up fake public and mock bustable
     *
     * @return void
     *
     * @access protected
     */
    protected function setUp()
    {
        parent::setUp();
        $this->helper = new \JnjxpTest\Html\MockBustable();
        $this->public = dirname(__DIR__) . '/MockPublic';
    }

    /**
     * helper busts href and src
     *
     * @return void
     *
     * @access public
     */
    public function testBustHrefAndSrc()
    {
        $decor = $this->helper->bust()->setPublic($this->public);

        $class = 'Jnjxp\Html\Helper\CacheBusterDecorator';
        $this->assertInstanceOf($class, $decor);

        $expected = '/build/BUSTED-FOO';
        $actual = $this->helper->bust()->testSrc('foo');
        $this->assertSame($expected, $actual);

        $expected = '/build/BUSTED-BAR';
        $actual = $this->helper->bust()->testHref('bar');
        $this->assertSame($expected, $actual);
    }

    /**
     * test buster can set manifest
     *
     * @return void
     *
     * @access public
     */
    public function testManifest()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $this->helper->bust('none')->testHref('none');
    }

    /**
     * test buster setable factory
     *
     * @return void
     *
     * @access public
     */
    public function testFactory()
    {
        $obj = (object) [];
        $this->helper->setCacheBusterFactory(
            function ($helper) use ($obj) {
                $helper;
                return $obj;
            }
        );

        $actual = $this->helper->bust();
        $this->assertSame($obj, $actual);
    }

    /**
     * test decorating bad methods
     *
     * @return void
     *
     * @access public
     */
    public function testBadMethod()
    {
        $this->setExpectedException('\BadMethodCallException');
        $this->helper->bust()->testNope();
    }

    /**
     * test invoke proxy
     *
     * @return void
     *
     * @access public
     */
    public function testInvoke()
    {

        $decor = $this->helper->bust()->setPublic($this->public);

        $actual = $decor('foo', 'bar', 'baz');

        $expect = [
            '/build/BUSTED-FOO',
            '/build/BUSTED-BAR',
            'baz'
        ];

        $this->assertSame($expect, $actual);

        $actual = $decor();

        $this->assertSame($decor, $actual);
    }
}
