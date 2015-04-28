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
* @category  Trait
* @package   Jnjxp\Html
* @author    Jake Johns <jake@jakejohns.net>
* @copyright 2015 Jake Johns
* @license   http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
* @link      http://jakejohns.net
 */

namespace Jnjxp\Html\Helper\Traits;

use InvalidArgumentException;

/**
 * CacheBusted
 *
 * @category Trait
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
trait CacheBusterTrait
{
    /**
     * manifest
     *
     * @var mixed
     * @access protected
     * @static
     */
    protected static $manifests;

    /**
     * defaultManifest
     *
     * @var mixed
     * @access protected
     */
    protected $defaultManifest;

    /**
    * getFile
    *
    * @param mixed $file     DESCRIPTION
    * @param mixed $manifest DESCRIPTION
    *
    * @return mixed
    *
    * @access public
    */
    public function bust($file, $manifest = null)
    {
        if (! $manifest) {
            $manifest = $this->getDefaultManifest();
        }

        $manifest = $this->loadManifest($manifest);

        if (isset($manifest->$file)) {
            return '/build/' . $manifest->$file;
        }

        throw new InvalidArgumentException(
            "File {$file} not defined in asset manifest."
        );
    }

    /**
    * setDefaultManifest
    *
    * @param mixed $manifest DESCRIPTION
    *
    * @return mixed
    *
    * @access public
    */
    public function setDefaultManifest($manifest)
    {
        $this->defaultManifest = $manifest;
    }

    /**
    * getDefaultManifest
    *
    * @return mixed
    *
    * @access public
    */
    public function getDefaultManifest()
    {
        if ( null === $this->defaultManifest ) {
            $this->defaultManifest = $_SERVER['DOCUMENT_ROOT']
                . '/build/rev-manifest.json';
        }
        return $this->defaultManifest;
    }

    /**
    * loadManifest
    *
    * @param mixed $file DESCRIPTION
    *
    * @return mixed
    *
    * @access public
    */
    public function loadManifest($file)
    {
        if (!isset(static::$manifests[$file])) {
            static::$manifests[$file] = json_decode(
                file_get_contents(
                    $file,
                    true
                )
            );
        }
        return static::$manifests[$file];
    }

}


