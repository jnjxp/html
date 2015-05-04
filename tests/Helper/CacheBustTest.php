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
 * CacheBust Test
 *
 * @category Test
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 * @see      PHPUnit_Framework_TestCase
 */
class CacheBustTest extends AbstractHelperTest
{

    /**
     * test helper busts
     *
     * @return void
     *
     * @access public
     */
    public function testBust()
    {
        $helper = $this->helper;
        $helper->setPublic(dirname(__DIR__) . '/MockPublic');
        $actual = $helper('foo');
        $expect = '/build/BUSTED-FOO';
        $this->assertSame($expect, $actual);
    }

    /**
     * test helper throws exception when file isnt in manifest
     *
     * @return void
     *
     * @access public
     */
    public function testNoFile()
    {
        $helper = $this->helper;
        $helper->setPublic(dirname(__DIR__) . '/MockPublic');
        $this->setExpectedException('\InvalidArgumentException');
        $helper->bust('none');
    }

    /**
     * test helper throws exception when manifest doesnt exist
     *
     * @return void
     *
     * @access public
     */
    public function testNoManifest()
    {
        $helper = $this->helper;
        $helper->setPublic(dirname(__DIR__) . '/MockPublic');
        $helper->setDefaultManifest('none');
        $this->setExpectedException('\InvalidArgumentException');
        $helper->bust('bar');
    }

}
