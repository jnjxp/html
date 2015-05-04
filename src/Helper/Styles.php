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

use Aura\Html\Helper\Styles as AuraStyles;
use Jnjxp\Html\Helper\Traits\CacheBustableTrait;

/**
 * HTML Styles
 *
 * @category Helper
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 * @see      AuraStyles
 */
class Styles extends AuraStyles
{
    use CacheBustableTrait;

    /**
     * capture
     *
     * @var mixed
     * @access protected
     */
    protected $capture = [];

    /**
     * makes an internal style tag
     *
     * @param string $style css snippet
     * @param array  $attr  attributes for style tag
     *
     * @return string
     *
     * @access public
     */
    public function inline($style, array $attr = null)
    {
        $attr = $this->escaper->attr(
            $this->fixInlineAttr($attr)
        );
        return "<style {$attr}>{$style}</style>";
    }

    /**
     * add inline conditional style
     *
     * @param string $cond  ie condition
     * @param string $style css snippet
     * @param array  $attr  attributes for style tag
     *
     * @return string
     *
     * @access public
     */
    public function inlineCond($cond, $style, array $attr = null)
    {
        $style = $this->inline($style, $attr);
        $cond  = $this->escaper->html($cond);
        return "<!--[if {$cond}]>{$style}<![endif]-->";
    }

    /**
     * add inline css
     *
     * @param string $style    css snippet
     * @param array  $attr     attributes for style tag
     * @param int    $position sort
     *
     * @return Styles
     *
     * @access public
     */
    public function addInline($style, array $attr = null, $position = 1000)
    {
        $this->addElement(
            $position,
            $this->inline($style, $attr)
        );
        return $this;
    }

    /**
     * add inline conditional css
     *
     * @param string $cond     ie condition
     * @param string $style    css snippet
     * @param array  $attr     attributes for style tag
     * @param int    $position sort
     *
     * @return Styles
     *
     * @access public
     */
    public function addInlineCond(
        $cond,
        $style,
        array $attr = null,
        $position = 1000
    ) {
        $this->addElement(
            $position,
            $this->inlineCond($cond, $style, $attr)
        );
        return $this;
    }

    /**
     * capture inline snippet
     *
     * @param array $attr     attributes for style tag
     * @param int   $position sort
     *
     * @return Styles
     *
     * @access public
     */
    public function inlineCaptureStart(array $attr = null, $position = 1000)
    {
        $this->capture[] = [
            'func' => 'addInline',
            'args' => [
                'style' => '',
                $attr,
                $position
            ]
        ];

        ob_start();
        return $this;
    }

    /**
     * capture inline conditional style
     *
     * @param mixed $cond     ie condition
     * @param array $attr     attributes for style tag
     * @param int   $position sort
     *
     * @return Styles
     *
     * @access public
     */
    public function inlineCondCaptureStart(
        $cond,
        array $attr = null,
        $position = 1000
    ) {
        $this->capture[] = [
            'func' => 'addInlineCond',
            'args' => [
                $cond,
                'style' => '',
                $attr,
                $position
            ]
        ];

        ob_start();
        return $this;
    }

    /**
     * end capture
     *
     * @return Styles
     *
     * @access public
     */
    public function inlineCaptureEnd()
    {
        $capture = array_pop($this->capture);
        $capture['args']['style'] = ob_get_clean();
        call_user_func_array(
            [$this, $capture['func']],
            $capture['args']
        );
        return $this;
    }

    /**
     * fix attributes
     *
     * @param array $attr attributes
     *
     * @return array
     *
     * @access protected
     */
    protected function fixInlineAttr(array $attr = null)
    {
        $attr = (array) $attr;

        $base = [
            'type' => 'text/css',
            'media' => 'screen',
        ];

        return array_merge($base, (array) $attr);
    }
}
