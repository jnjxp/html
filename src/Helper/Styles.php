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
 * Scripts
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
     * inline
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $style DESCRIPTION
     * @param array $attr  DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function inline($style, array $attr = null)
    {
        $attr = $this->fixInlineAttr($attr);
        return "<style {$attr}>{$style}</style>";
    }

    /**
     * inlineCond
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $cond  DESCRIPTION
     * @param mixed $style DESCRIPTION
     * @param array $attr  DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
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
     * addInline
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $style    DESCRIPTION
     * @param array $attr     DESCRIPTION
     * @param int   $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
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
     * addInlineCond
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $cond     DESCRIPTION
     * @param mixed $style    DESCRIPTION
     * @param array $attr     DESCRIPTION
     * @param int   $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
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
     * inlineCaptureStart
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param array $attr     DESCRIPTION
     * @param int   $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
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
    }

    /**
     * inlineCaptureCondStart
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $cond     DESCRIPTION
     * @param array $attr     DESCRIPTION
     * @param int   $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function inlineCondCaptureStart(
        $cond,
        array $attr = null,
        $position = 1000
    ) {
        $this->capture[] = [
            'func' => 'addInline',
            'args' => [
                $cond,
                'style' => '',
                $attr,
                $position
            ]
        ];

        ob_start();
    }

    /**
     * inlineCaptureEnd
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @return mixed
     * @throws exceptionclass [description]
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
    }

    /**
     * fixInlineAttr
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param array $attr DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
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
