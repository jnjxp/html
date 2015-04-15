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
* @category  Factory
* @package   Jnjxp\Html
* @author    Jake Johns <jake@jakejohns.net>
* @copyright 2015 Jake Johns
* @license   http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
* @link      http://jakejohns.net
 */

namespace Jnjxp\Html;

use Aura\Html\HelperLocator as BaseLocator;


/**
 * HelperLocator
 *
 * Description Here!
 *
 * @category CategoryName
 * @package  PackageName
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 */
class HelperLocatorContainer extends BaseLocator
{

    /**
     * __call
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $name DESCRIPTION
     * @param mixed $args DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function __call($name, $args)
    {
        $helper = $this->get($name);

        if (!count($args)) {
            return $helper;
        }

        if ($helper instanceof BaseLocator) {
            $helper = $helper->get(array_shift($args));
        }

        return call_user_func_array(
            $helper,
            $args
        );
    }

    /**
     * __get
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $name DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function __get($name)
    {
        return $this->get($name);
    }
}
