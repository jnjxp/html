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
* @category  Helper
* @package   Jnjxp\Html
* @author    Jake Johns <jake@jakejohns.net>
* @copyright 2015 Jake Johns
* @license   http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
* @link      http://jakejohns.net
 */

namespace Jnjxp\Html\Helper;

use Aura\Html\Helper\Title as AuraTitle;

/**
 * HTML Title tags and meta
 *
 * @category Helper
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
class Title extends AuraTitle
{

    /**
     * site title
     *
     * @var string
     * @access protected
     */
    protected $site;

    /**
     * set site title for meta
     *
     * @param mixed $site title of site
     *
     * @return Title
     *
     * @access public
     */
    public function setSite($site)
    {
        $this->site = $site;
        return $this;
    }

    /**
     * outputs title and site title meta tags
     *
     * @return string
     *
     * @access public
     */
    public function __toString()
    {

        $meta = [
            'name'     => 'title',
            'property' => 'og:title',
            'content'  => $this->title
        ];

        $site = [
            'property' => 'og:site_name',
            'content'  => $this->site
        ];

        $title = $this->indent(1, "<title>{$this->title}</title>")
            . $this->indent(1, $this->void('meta', $meta))
            . ($this->site ? $this->indent(1, $this->void('meta', $site)) : '');

        $this->title = null;
        $this->site = null;

        return $title;
    }
}
