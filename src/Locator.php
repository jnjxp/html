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
* @category  Locator
* @package   Jnjxp\Html
* @author    Jake Johns <jake@jakejohns.net>
* @copyright 2015 Jake Johns
* @license   http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
* @link      http://jakejohns.net
 */

namespace Jnjxp\Html;

/**
 * Helper Service Locator
 *
 * Calls helpers created from factories
 *
 * @category Locator
 * @package  Jnjxp\HtmlHead
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 */
class Locator
{

    /**
     * Helper factories
     *
     * @var array
     * @access protected
     */
    protected $factories = array();

    /**
     * Helper instances
     *
     * @var array
     * @access protected
     */
    protected $helpers = array();

    /**
     * Creates callable, invokeable container of helpers
     *
     * @param array $factories callables indexed by names
     *
     * @access public
     */
    public function __construct($factories = array())
    {
        $this->factories = $factories;
    }

    /**
     * Invokes a helper
     *
     * @param string $name name of helper to instantiate and call
     * @param array  $args arguments to pass to helper
     *
     * @return mixed
     *
     * @access public
     */
    public function __call($name, $args)
    {
        return call_user_func_array(
            $this->get($name),
            $args
        );
    }

    /**
     * Magically gets a helper as a property
     *
     * @param string $name name of helper
     *
     * @return mixed
     *
     * @access public
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Calls helper with args if args present
     *
     * @param array $args arguments
     *
     * @return mixed
     *
     * @access public
     */
    public function __invoke($args)
    {
        if (count($args)) {
            $this->__call(array_shift($args), $args);
        }
        return $this;
    }

    /**
     * Sets a factory
     *
     * @param string   $name     name of helper
     * @param callable $callable callable factory to create helper
     *
     * @return mixed
     *
     * @access public
     */
    public function set($name, $callable)
    {
        $this->factories[$name] = $callable;
        unset($this->helpers[$name]);
        return $this;
    }

    /**
     * Checks if helper exists
     *
     * @param string $name name fo helper
     *
     * @return bool
     *
     * @access public
     */
    public function has($name)
    {
        return isset($this->factories[$name]);
    }

    /**
     * gets a helper
     *
     * @param string $name name of helper
     *
     * @return mixed
     * @throws Exception if factory is not set
     *
     * @access public
     */
    public function get($name)
    {
        if (! $this->has($name)) {
            throw new Exception\HelperNotFoundException($name);
        }

        if (! isset($this->helpers[$name])) {
            $factory = $this->factories[$name];
            $this->helpers[$name] = $factory();
        }

        return $this->helpers[$name];
    }
}
