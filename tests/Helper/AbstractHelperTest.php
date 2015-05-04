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

use Aura\Html\EscaperFactory;

/**
 * AbstractHelperTest
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
abstract class AbstractHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * instance of helper being tested
     *
     * @var mixed
     * @access protected
     */
    protected $helper;

    /**
     * calls function to instantiate helper based on test class name
     *
     * @return mixed
     *
     * @access protected
     */
    protected function setUp()
    {
        parent::setUp();
        $this->helper = $this->newHelper();
    }

    /**
     * instantiate helper based on test class name
     *
     * @return mixed
     *
     * @access protected
     */
    protected function newHelper()
    {
        $class = 'Jnjxp' . substr(get_class($this), 9, -4);
        return new $class((new EscaperFactory())->newInstance());
    }
}
