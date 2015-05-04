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

use Aura\Html\Helper\Links as AuraLinksHelper;

/**
 * Icons
 *
 * @category Helper
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
class Links extends AuraLinksHelper
{

    /**
     * default icons data array
     *
     * @var array
     * @access protected
     */
    protected $icons = [
        'apple-touch-icon' => [
            'pattern' => '/assets/ico/apple-touch-icon-%sx%1$s.png',
            'sizes' => [144, 114, 72, 57]
        ],
        'icon' => [
            'pattern' => '/assets/ico/favicon-%sx%1$s.png',
            'sizes' => [192, 96, 32, 16],
            'attr' => ['type' => 'image/png']
        ]
    ];


    /**
     * add icons based on cofig array
     *
     * @param array $icons data to create icons from
     *
     * @return Links
     *
     * @access public
     */
    public function icons(array $icons = null)
    {
        foreach ($this->fixIconsArray(($icons ?: $this->icons)) as $icon) {
            $this->add($icon);
        }
        return $this;
    }

    /**
     * fix icons data into usable array
     *
     * @param array $icons data array to fix
     *
     * @return array
     *
     * @access protected
     */
    protected function fixIconsArray(array $icons)
    {
        $array = [];
        foreach ($icons as $rel => $data) {
            foreach ((array) $data['sizes'] as $size) {
                $array[] = array_merge_recursive(
                    [
                        'rel'   => $rel,
                        'sizes' => "{$size}x{$size}",
                        'href'  => sprintf($data['pattern'], $size),
                    ],
                    (isset($data['attr']) ? $data['attr'] : [])
                );
            }
        }
        return $array;
    }
}
