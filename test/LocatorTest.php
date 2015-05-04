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

namespace JnjxpTest\Html;

use Jnjxp\Html\Factory;

/**
 * Locator Test
 *
 * @category Test
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 * @see      PHPUnit_Framework_TestCase
 */
class LocatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * locator
     *
     * @var Jnjxp\Html\Locator
     * @access protected
     */
    protected $locator;

    /**
     * Use Factory to set up instance of locator
     *
     * @return void
     *
     * @access protected
     */
    protected function setUp()
    {
        $this->locator = (new Factory())->newInstance();
    }

    /**
     * helperProvider
     *
     * @return array
     *
     * @access public
     */
    public function helperProvider()
    {
        return array(
            ['a', '\Aura\Html\Helper\Anchor'],
            ['anchor', '\Aura\Html\Helper\Anchor'],
            ['aRaw', '\Aura\Html\Helper\AnchorRaw'],
            ['anchorRaw', '\Aura\Html\Helper\AnchorRaw'],
            ['form', '\Aura\Html\Helper\Form'],
            ['img', '\Aura\Html\Helper\Img'],
            ['image', '\Aura\Html\Helper\Img'],
            ['label', '\Aura\Html\Helper\Label'],
            ['ol', '\Aura\Html\Helper\Ol'],
            ['tag', '\Aura\Html\Helper\Tag'],
            ['ul', '\Aura\Html\Helper\Ul'],
            ['base', '\Aura\Html\Helper\Base'],

            ['escape', '\Aura\Html\Escaper'],
            ['input', '\Aura\Html\Helper\Input'],

            ['cacheBust', '\Jnjxp\Html\Helper\CacheBust'],
            ['links', '\Jnjxp\Html\Helper\Links'],
            ['metas', '\Jnjxp\Html\Helper\Metas'],
            ['scripts', '\Jnjxp\Html\Helper\Scripts'],
            ['scriptsFoot', '\Jnjxp\Html\Helper\Scripts'],
            ['styles', '\Jnjxp\Html\Helper\Styles'],
            ['title', '\Jnjxp\Html\Helper\Title'],
            ['icon', '\Jnjxp\Html\Helper\Icon'],
            ['ico', '\Jnjxp\Html\Helper\Icon'],
            ['modal', '\Jnjxp\Html\Helper\Modal'],
            ['breadcrumb', '\Jnjxp\Html\Helper\Breadcrumb'],
        );
    }

    /**
     * testHelpers
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param string $name  name of helper
     * @param string $class expected helper class
     *
     * @return void
     *
     * @access public
     * @dataProvider helperProvider
     */
    public function testHelpers($name, $class)
    {
        $helper = $this->locator->get($name);
        $this->assertInstanceOf($class, $helper);
    }

    /**
     * test basic locator functions
     *
     * @return void
     *
     * @access public
     */
    public function test()
    {
        // set
        $actual = $this->locator->set(
            'mockHelper',
            function () {
                return new MockHelper;
            }
        );
        $expect = 'Jnjxp\Html\Locator';
        $this->assertInstanceOf($expect, $actual);


        // get
        $expect = 'JnjxpTest\Html\MockHelper';
        $actual = $this->locator->get('mockHelper');
        $this->assertInstanceOf($expect, $actual);

        // __get
        $expect = 'JnjxpTest\Html\MockHelper';
        $actual = $this->locator->mockHelper;
        $this->assertInstanceOf($expect, $actual);


        // __call
        $expect = 'Test Valid';
        $actual = $this->locator->mockHelper('Valid');
        $this->assertSame($expect, $actual);

        // __invoke helper
        $expect = 'Test Valid';
        $locator = $this->locator;
        $actual = $locator('mockHelper', 'Valid');
        $this->assertSame($expect, $actual);

        // __invoke fluent
        $locator = $this->locator;
        $actual = $locator();
        $this->assertSame($locator, $actual);

        // has
        $has = $this->locator->has('mockHelper');
        $this->assertTrue($has);

        // invalid helper
        $this->setExpectedException('Jnjxp\Html\Exception\HelperNotFoundException');
        $this->locator->get('noSuchHelper');
    }
}
