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

use Aura\Html\EscaperFactory;
use Aura\Html\HelperLocatorFactory as AuraFactory;

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
class Factory
{
    /**
     * escaper
     *
     * @var mixed
     * @access protected
     */
    protected $escaper;

    /**
     * helpers
     *
     * @var array
     * @access protected
     */
    protected $helpers = array(
        // Aura
        'a'         => '\AuraHtml\Helper\Anchor',
        'anchor'    => '\AuraHtml\Helper\Anchor',
        'aRaw'      => '\AuraHtml\Helper\AnchorRaw',
        'anchorRaw' => '\AuraHtml\Helper\AnchorRaw',
        'form'      => '\AuraHtml\Helper\Form',
        'img'       => '\AuraHtml\Helper\Img',
        'image'     => '\AuraHtml\Helper\Img',
        'label'     => '\AuraHtml\Helper\Label',
        'ol'        => '\AuraHtml\Helper\Ol',
        'tag'       => '\AuraHtml\Helper\Tag',
        'ul'        => '\AuraHtml\Helper\Ul',
        'base'      => '\AuraHtml\Helper\Base',

        // Jnjxp
        'cacheBust'  => '\Jnjxl\Html\Helper\CacheBust',
        'links'      => '\Jnjxl\Html\Helper\Links',
        'metas'      => '\Jnjxl\Html\Helper\Metas',
        'scripts'    => '\Jnjxl\Html\Helper\Scripts',
        'styles'     => '\Jnjxl\Html\Helper\Styles',
        'title'      => '\Jnjxl\Html\Helper\Title',
        'icon'       => '\Jnjxl\Html\Helper\Icon',
        'ico'        => '\Jnjxl\Html\Helper\Icon',
        'modal'      => '\Jnjxl\Html\Helper\Modal',
        'breadcrumb' => '\Jnjxl\Html\Helper\Breadcrumb',
    );

    /**
     * Creates a factory
     *
     * @param mixed $encoding encoding
     * @param mixed $flags    flags
     *
     * @access public
     */
    public function __construct($encoding = null, $flags = null)
    {
        $factory = new EscaperFactory($encoding, $flags);
        $this->escaper = $factory->newInstance();
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
        $locator = new Locator($this->getFactories());
        return $locator;
    }

    /**
     * getFactories
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access protected
     */
    protected function getFactories()
    {
        $escaper = $this->escaper;
        $input   = (new AuraFactory())->newInputInstance();

        $factories = [
            'escape' => function () use ($escaper) {
                return $escaper;
            },
            'input' => function () use ($input) {
                return $input;
            }
        ];

        foreach ($this->helpers as $name => $class) {
            $factories[$name] = function () use ($class, $escaper) {
                return new $class($escaper);
            };
        }

        return $factories;
    }
}
