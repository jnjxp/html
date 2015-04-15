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

use Jnjxp\Html\HtmlHelperLocatorFactory as HtmlFactory;

use Jnjxp\HtmlHead\HelperLocatorFactory as HeadFactory;

use Aura\Html\HelperLocator;

/**
 * HelperLocatorFactory
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
class HelperLocatorContainerFactory
{

    /**
     * flags
     *
     * @var mixed
     * @access protected
     */
    protected $flags;

    /**
     * encoding
     *
     * @var mixed
     * @access protected
     */
    protected $encoding;

    /**
     * __construct
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $encoding DESCRIPTION
     * @param mixed $flags    DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function __construct($encoding = null, $flags = null)
    {
        $this->encoding = $encoding;
        $this->flags = $flags;
    }

    /**
     * newInstance
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function newInstance()
    {
        $encoding = $this->encoding;
        $flags    = $this->flags;

        return new HelperLocatorContainer(
            [
                'head' => function () use ($encoding, $flags) {
                    return (new HeadFactory($encoding, $flags))->newInstance();
                },
                'html' => function () use ($encoding, $flags) {
                    return (new HtmlFactory($encoding, $flags))->newInstance();
                },
            ]
        );
    }
}
