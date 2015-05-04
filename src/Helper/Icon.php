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

use Aura\Html\Helper\AbstractHelper;

/**
 * Create an icon
 *
 * Description Here!
 *
 * @category Helper
 * @package  Jnjxp\Icon
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 * @see      AbstractHelper
 */
class Icon extends AbstractHelper
{

    /**
     * create markup for an icon with optional alt
     *
     * @param string $name name of icon
     * @param mixed  $alt  false for no alt, true for name as alt, or string for alt
     *
     * @return string
     *
     * @access public
     */
    public function __invoke($name, $alt = false)
    {
        $attr = $this->escaper->attr(
            [
                'class'       => ['icon', "icon-{$name}"],
                'aria-hidden' => 'true'
            ]
        );

        $ico = "<span {$attr}><!-- --></span>";

        if ($alt) {
            if (true === $alt) {
                $alt = $name;
            }
            $alt = $this->escaper->html($alt);
            $alt = "<span class=\"sr-only\">{$alt}</span>";
            $ico = "{$ico} {$alt}";
        }

        return $ico;
    }
}
