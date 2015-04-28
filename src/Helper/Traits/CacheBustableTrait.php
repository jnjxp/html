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
* @category  Traits
* @package   Jnjxp\Html
* @author    Jake Johns <jake@jakejohns.net>
* @copyright 2015 Jake Johns
* @license   http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
* @link      http://jakejohns.net
 */

namespace Jnjxp\Html\Helper\Traits;

use Jnjxp\Html\Helper\CacheBusterDecorator;

/**
 * CacheBustableTrait
 *
 * @category Traits
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 */
trait CacheBustableTrait
{
    /**
     * cacheBusterFactory
     *
     * @var mixed
     * @access protected
     */
    protected $cacheBusterFactory;

    /**
    * bust
    *
    * @param mixed $manifest DESCRIPTION
    *
    * @return mixed
    *
    * @access public
    */
    public function bust($manifest = null)
    {
        $factory = $this->getCacheBusterFactory();
        return $factory($this, $manifest);
    }

    /**
    * setCacheBusterFactory
    *
    * @param mixed $factory DESCRIPTION
    *
    * @return mixed
    *
    * @access public
    */
    public function setCacheBusterFactory($factory)
    {
        $this->cacheBusterFactory = $factory;
    }

    /**
    * getCacheBusterFactory
    *
    * @return mixed
    *
    * @access public
    */
    public function getCacheBusterFactory()
    {
        if (null === $this->cacheBusterFactory) {
            $this->cacheBusterFactory = function ($helper, $manifest) {
                return new CacheBusterDecorator($helper, $manifest);
            };
        }
        return $this->cacheBusterFactory;
    }

}
