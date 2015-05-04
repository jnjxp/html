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

use Jnjxp\Html\Helper\Traits\CacheBustableTrait;

/**
 * MockBustable
 *
 * @category Test
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 */
class MockBustable
{
    use CacheBustableTrait;

    /**
     * testHref
     *
     * @param string $href Fake Property to bust
     *
     * @return string
     *
     * @access public
     */
    public function testHref($href)
    {
        return $href;
    }

    /**
     * testSrc
     *
     * @param string $src Fake Property to bust
     *
     * @return string
     *
     * @access public
     */
    public function testSrc($src)
    {
        return $src;
    }

    /**
     * testFoo
     *
     * @param string $foo Fake Property to leave be
     *
     * @return string
     *
     * @access public
     */
    public function testFoo($foo)
    {
        return $foo;
    }

    /**
     * mock add
     *
     * @param string $href Fake Property to bust
     * @param string $src  Fake Property to bust
     * @param string $foo  Fake Property to leave be
     *
     * @return array
     *
     * @access public
     */
    public function add($href, $src, $foo)
    {
        return [
            $href,
            $src,
            $foo
        ];
    }
}
