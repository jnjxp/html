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
* @category  Decorator
* @package   Jnjxp\Html
* @author    Jake Johns <jake@jakejohns.net>
* @copyright 2015 Jake Johns
* @license   http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
* @link      http://jakejohns.net
 */

namespace Jnjxp\Html\Helper;

use Jnjxp\Html\Helper\Traits\CacheBusterTrait;

use BadMethodCallException;

use ReflectionMethod;

/**
 * Decorate helper with cachebusting function
 *
 * @category Decorator
 * @package  Jnjxp\Helper
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
class CacheBusterDecorator
{
    use CacheBusterTrait;

    /**
     * helper
     *
     * @var mixed
     * @access protected
     */
    protected $helper;

    /**
     * decorate a helper
     *
     * @param object $helper helper to decorate
     *
     * @access public
     */
    public function __construct($helper)
    {
        $this->helper = $helper;
    }

    /**
    * proxy call to helper, busting any attribute named href or src
    *
    * @param string $method method to call
    * @param array  $args   args
    *
    * @return mixed
    * @throws BadMethodCallException if helper does not have method
    *
    * @access public
    */
    public function __call($method, $args)
    {
        if (!method_exists($this->helper, $method)) {
            throw new BadMethodCallException("Undefined method $method");
        }

        $reflection = new ReflectionMethod($this->helper, $method);
        foreach ($reflection->getParameters() as $key => $param) {
            if (isset($args[$key]) && in_array($param->name, ['href', 'src'])) {
                $args[$key] = $this->bust($args[$key]);
            }
        }

        return $reflection->invokeArgs($this->helper, $args);
    }

    /**
     * proxy to add method via busting __call
     *
     * @return mixed
     *
     * @access public
     */
    public function __invoke()
    {
        $args = func_get_args();
        if (! empty($args)) {
            return call_user_func_array(array($this, 'add'), $args);
        }
        return $this;
    }
}
