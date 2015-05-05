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
     * decorated instance factory
     *
     * @var callable factory to create a cache bust decorated object
     * @access protected
     */
    protected $cacheBusterFactory;

    /**
     * decorated instance
     *
     * @var CacheBusterDecorator
     * @access protected
     */
    protected $busted;

    /**
    * decorate object and optionally set default manifest
    *
    * @param string $manifest path to manifest
    *
    * @return CacheBusterDecorator
    *
    * @access public
    */
    public function bust($manifest = null)
    {
        if (null === $this->busted) {
            $factory = $this->getCacheBusterFactory();
            $this->busted = $factory($this);
        }

        if ($manifest) {
            $this->busted->setDefaultManifest($manifest);
        }

        return $this->busted;
    }

    /**
    * set decorator factory
    *
    * @param callable $factory factory to create decorated instance
    *
    * @return mixed
    *
    * @access public
    */
    public function setCacheBusterFactory($factory)
    {
        $this->cacheBusterFactory = $factory;
        return $this;
    }

    /**
    * gets decorated instance factory
    *
    * @return callable
    *
    * @access public
    */
    public function getCacheBusterFactory()
    {
        if (null === $this->cacheBusterFactory) {
            $this->cacheBusterFactory = function ($helper) {
                return new CacheBusterDecorator($helper);
            };
        }
        return $this->cacheBusterFactory;
    }
}
