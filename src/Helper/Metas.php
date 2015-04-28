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
 * Description
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
     * addProperty
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $property DESCRIPTION
     * @param mixed $content  DESCRIPTION
     * @param int   $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
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
     * addOpenGraphProperty
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $property DESCRIPTION
     * @param mixed $content  DESCRIPTION
     * @param int   $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
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
     * charset
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $charset  DESCRIPTION
     * @param int   $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function charset($charset, $position = 10)
    {
        $this->add(['charset' => $charset], $position);
        return $this;
    }

    /**
     * compat
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $content  DESCRIPTION
     * @param int   $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function compat($content, $position = 100)
    {
        $this->addHttp('X-UA-Compatible', $content, $position);
    }

    /**
     * description
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $description DESCRIPTION
     * @param int   $position    DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
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
     * loc
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $locale   DESCRIPTION
     * @param int   $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function loc($locale, $position = 100)
    {
        $this->addOpenGraphProperty('locale', $locale, $position);
        return $this;
    }

    /**
     * robots
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $robots   DESCRIPTION
     * @param int   $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function robots($robots, $position = 100)
    {
        $this->addName('robots', $robots, $position);
        return $this;
    }

    /**
     * url
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $url      DESCRIPTION
     * @param int   $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function url($url, $position = 100)
    {
        $this->addOpenGraphProperty('url', $url, $position);
        return $this;
    }


    /**
     * viewport
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $viewport DESCRIPTION
     * @param int   $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function viewport($viewport, $position = 100)
    {
        $this->addName('viewport', $viewport, $position);
        return $this;
    }

    /**
     * image
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $image    DESCRIPTION
     * @param int   $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
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
    }
}
