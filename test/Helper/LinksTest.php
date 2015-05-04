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
 * Links Test
 *
 * @category Test
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 * @see      PHPUnit_Framework_TestCase
 */
class LinksTest extends AbstractHelperTest
{

    /**
     * helper sets up icons based on array
     *
     * @return void
     *
     * @access public
     */
    public function testIcons()
    {
        $helper = $this->helper;
        $data = [
            'ico' => [
                'pattern' => '/%s',
                'sizes' => [1],
                'attr' => ['type' => 'foo']
            ]
        ];

        $expect = '    <link rel="ico" sizes="1x1" href="/1" type="foo" />'
            . PHP_EOL;
        $actual = $helper->icons($data)->__toString();

        $this->assertSame($expect, $actual);
    }

}
