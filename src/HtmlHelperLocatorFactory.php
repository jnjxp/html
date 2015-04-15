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

use Jnjxp\HtmlHead\HelperLocatorFactory as HeadFactory;

use Aura\Html\Helper;
use Aura\Html\HelperLocator;
use Aura\Html\HelperLocatorFactory;

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
class HtmlHelperLocatorFactory extends HelperLocatorFactory
{

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
        $escaper = $this->escaper;
        $input   = $this->newInputInstance();
        return new HelperLocator(
            [
                'a' => function () use ($escaper) {
                    return new Helper\Anchor($escaper);
                },
                'anchor' => function () use ($escaper) {
                    return new Helper\Anchor($escaper);
                },
                'aRaw' => function () use ($escaper) {
                    return new Helper\AnchorRaw($escaper);
                },
                'anchorRaw' => function () use ($escaper) {
                    return new Helper\AnchorRaw($escaper);
                },
                'escape' => function () use ($escaper) {
                    return $escaper;
                },
                'form' => function () use ($escaper) {
                    return new Helper\Form($escaper);
                },
                'img' => function () use ($escaper) {
                    return new Helper\Img($escaper);
                },
                'image' => function () use ($escaper) {
                    return new Helper\Img($escaper);
                },
                'input' => function () use ($input) {
                    return $input;
                },
                'label' => function () use ($escaper) {
                    return new Helper\Label($escaper);
                },
                'ol' => function () use ($escaper) {
                    return new Helper\Ol($escaper);
                },
                'tag' => function () use ($escaper) {
                    return new Helper\Tag($escaper);
                },
                'ul' => function () use ($escaper) {
                    return new Helper\Ul($escaper);
                },
            ]
        );
    }
}
