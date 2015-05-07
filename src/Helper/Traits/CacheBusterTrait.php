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
     * loaded manifests
     *
     * @var array
     * @access protected
     * @static
     */
    protected static $manifests = array();

    /**
     * path to pubic root
     *
     * @var string
     * @access protected
     * @static
     */
    protected static $public;

    /**
     * default manifest
     *
     * @var string
     * @access protected
     */
    protected $defaultManifest;

    /**
    * get a versioned file name based on file name
    *
    * @param mixed $file     file key to look for in manifest
    * @param mixed $manifest path to manifest, relative to root
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

        $dir = str_replace(
            static::$public,
            '',
            dirname($manifest)
        );

        $manifest = $this->loadManifest($manifest);

        if (isset($manifest->$file)) {
            return "/{$dir}/{$manifest->$file}";
        }

        throw new InvalidArgumentException(
            "File {$file} not defined in asset manifest."
        );
    }

    /**
     * set path to public root
     *
     * @param mixed $public path to public root
     *
     * @return CacheBusterInterface
     *
     * @access public
     */
    public function setPublic($public)
    {
        static::$public = realpath($public);
        return $this;
    }

    /**
    * set a default manifest
    *
    * @param string $manifest path to manifest
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
    * gets default manifest
    *
    * @return string
    *
    * @access public
    */
    public function getDefaultManifest()
    {
        if (null === $this->defaultManifest) {
            $this->defaultManifest = 'build/rev-manifest.json';
        }
        return $this->defaultManifest;
    }

    /**
    * loads a manifest from json file
    *
    * @param string $file path to manifest
    *
    * @return Object
    *
    * @access public
    */
    public function loadManifest($file)
    {
        if (!isset(static::$manifests[$file])) {
            $path = realpath(static::$public . "/{$file}");

            if (! $path) {
                throw new InvalidArgumentException(
                    "Manifest {$file} does not exist"
                );
            }

            static::$manifests[$file] = json_decode(
                file_get_contents(
                    $path,
                    true
                )
            );
        }
        return static::$manifests[$file];
    }
}
