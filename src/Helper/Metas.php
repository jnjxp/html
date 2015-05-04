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

use Aura\Html\Helper\Metas as AuraMetas;

/**
 * HTML Meta tags
 *
 * @category Helper
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
class Metas extends AuraMetas
{

    /**
     * add a property meta tag
     *
     * eg: <meta property="foo" content="bar" />
     *
     * @param string $property property name
     * @param string $content  property value
     * @param int    $position sort order
     *
     * @return Metas
     *
     * @access public
     */
    public function addProperty($property, $content, $position = 100)
    {
        $attr = [
            'property' => $property,
            'content' => $content
        ];
        $this->add($attr, $position);
        return $this;
    }

    /**
     * add OpenGraph Property
     *
     * http://ogp.me/
     * eg: <meta property="og:foo" content="bar" />
     *
     * @param string $property property name without the "og:"
     * @param string $content  content of the property
     * @param int    $position sort order
     *
     * @return Metas
     *
     * @access public
     */
    public function addOpenGraphProperty($property, $content, $position = 100)
    {
        $this->addProperty(
            "og:{$property}",
            $content,
            $position
        );
        return $this;
    }

    /**
     * adds character set meta, default to utf-8
     *
     * @param string $charset  charset name
     * @param int    $position sort order
     *
     * @return Metas
     *
     * @access public
     */
    public function charset($charset = 'UTF-8', $position = 10)
    {
        $this->add(['charset' => $charset], $position);
        return $this;
    }

    /**
     * set compatible mode for ie, default to "edge"
     *
     * https://www.modern.ie/en-us/performance/how-to-use-x-ua-compatible
     *
     * @param string $content  IE=mode
     * @param int    $position sort order
     *
     * @return Metas
     *
     * @access public
     */
    public function compat($content = 'IE=edge', $position = 100)
    {
        $this->addHttp('X-UA-Compatible', $content, $position);
        return $this;
    }

    /**
     * set description meta including OG property
     *
     * @param string $description description
     * @param int    $position    sort order
     *
     * @return Metas
     *
     * @access public
     */
    public function description($description, $position = 100)
    {
        $this->add(
            [
                'name' => 'description',
                'property' => 'og:description',
                'content' => $description
            ],
            $position
        );
        return $this;
    }

    /**
     * set open graph locale, default to 'en_US'
     *
     * @param string $locale   language_TERRITORY
     * @param int    $position sort order
     *
     * @return Metas
     *
     * @access public
     */
    public function loc($locale = 'en_US', $position = 100)
    {
        $this->addOpenGraphProperty('locale', $locale, $position);
        return $this;
    }

    /**
     * set robot meta, default to index, follow
     *
     * @param string $robots   DESCRIPTION
     * @param int    $position sort order
     *
     * @return Metas
     *
     * @access public
     */
    public function robots($robots = 'index, follow', $position = 100)
    {
        $this->addName('robots', $robots, $position);
        return $this;
    }

    /**
     * set opengraph url
     *
     * @param string $url      DESCRIPTION
     * @param int    $position sort order
     *
     * @return Metas
     *
     * @access public
     */
    public function url($url, $position = 100)
    {
        $this->addOpenGraphProperty('url', $url, $position);
        return $this;
    }


    /**
     * set viewpoer setting,
     *
     * default 'width=device-width, initial-scale=1, user-scalable=no'
     *
     * @param string $viewport viewport mode
     * @param int    $position sort order
     *
     * @return Metas
     *
     * @access public
     */
    public function viewport(
        $viewport = 'width=device-width, initial-scale=1, user-scalable=no',
        $position = 100
    ) {
        $this->addName('viewport', $viewport, $position);
        return $this;
    }

    /**
     * set opengraph and rel image
     *
     * @param string $image    DESCRIPTION
     * @param int    $position sort order
     *
     * @return Metas
     *
     * @access public
     */
    public function image($image, $position = 100)
    {
        $this->add(
            [
                'name' => 'image',
                'property' => 'og:image',
                'content' => $image
            ],
            $position
        );

        $this->addElement(
            $position,
            $this->void(
                'link',
                [
                    'rel'  => 'image_src',
                    'href' => $image
                ]
            )
        );
        return $this;
    }
}
