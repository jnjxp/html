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
 * @category Factory
 * @package  Jnjxp\Html
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
     * @var \Aura\Html\Escaper
     * @access protected
     */
    protected $escaper;

    /**
     * helpers for which to create factories
     *
     * @var array
     * @access protected
     */
    protected $helpers = array(
        // Aura
        'a'         => '\Aura\Html\Helper\Anchor',
        'anchor'    => '\Aura\Html\Helper\Anchor',
        'aRaw'      => '\Aura\Html\Helper\AnchorRaw',
        'anchorRaw' => '\Aura\Html\Helper\AnchorRaw',
        'form'      => '\Aura\Html\Helper\Form',
        'img'       => '\Aura\Html\Helper\Img',
        'image'     => '\Aura\Html\Helper\Img',
        'label'     => '\Aura\Html\Helper\Label',
        'ol'        => '\Aura\Html\Helper\Ol',
        'tag'       => '\Aura\Html\Helper\Tag',
        'ul'        => '\Aura\Html\Helper\Ul',
        'base'      => '\Aura\Html\Helper\Base',

        // Jnjxp
        'cacheBust'   => '\Jnjxp\Html\Helper\CacheBust',
        'links'       => '\Jnjxp\Html\Helper\Links',
        'metas'       => '\Jnjxp\Html\Helper\Metas',
        'scripts'     => '\Jnjxp\Html\Helper\Scripts',
        'scriptsFoot' => '\Jnjxp\Html\Helper\Scripts',
        'styles'      => '\Jnjxp\Html\Helper\Styles',
        'title'       => '\Jnjxp\Html\Helper\Title',
        'icon'        => '\Jnjxp\Html\Helper\Icon',
        'ico'         => '\Jnjxp\Html\Helper\Icon',
        'modal'       => '\Jnjxp\Html\Helper\Modal',
        'breadcrumb'  => '\Jnjxp\Html\Helper\Breadcrumb',
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
     * create locator
     *
     * @return Locator
     *
     * @access public
     */
    public function newInstance()
    {
        $locator = new Locator($this->getFactories());
        return $locator;
    }

    /**
     * create array of factories
     *
     * @return callable[]
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
