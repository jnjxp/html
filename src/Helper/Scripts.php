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

use Aura\Html\Helper\Scripts as AuraScripts;
use Jnjxp\Html\Helper\Traits\CacheBustableTrait;

/**
 * HTML Scripts
 *
 * @category Helper
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 * @see      AuraScripts
 */
class Scripts extends AuraScripts
{
    use CacheBustableTrait;

    /**
     * started capture meta
     *
     * @var array
     * @access protected
     */
    protected $capture = [];

    /**
     * addInline
     *
     * @param string $script   javascript snippet
     * @param int    $position sort order
     *
     * @return Scripts
     *
     * @access public
     */
    public function addInline($script, $position = 1000)
    {
        $attr = $this->escaper->attr(['type' => 'text/javascript']);
        $tag  = "<script $attr>{$script}</script>";
        $this->addElement($position, $tag);
        return $this;
    }

    /**
     * add an event listner
     *
     * @param string $function javascript sniuppet
     * @param string $event    event to bind to, defaults to document
     * @param string $node     node to bind
     * @param bool   $wrap     if true, $funciton is wrappped in a function
     * @param int    $position sort order
     *
     * @return Scripts
     *
     * @access public
     */
    public function addEventListener(
        $function,
        $event = null,
        $node = null,
        $wrap = false,
        $position = 1000
    ) {
        $event = $event ?: 'DOMContentLoaded';
        $node  = $node  ?: 'document';

        $function = ($wrap ? "function(event) { {$function} }" : $function);

        $this->addInline(
            "{$node}.addEventListener(\"{$event}\", {$function});",
            $position
        );
        return $this;
    }

    /**
     * start capturing a snippet
     *
     * @param int $position sort order
     *
     * @return Scripts
     *
     * @access public
     */
    public function inlineCaptureStart($position = 1000)
    {
        $this->capture[] = [
            'func' => 'addInline',
            'args' => [
                $position
            ]
        ];
        ob_start();
        return $this;
    }

    /**
     * start capturing an event to bind
     *
     * @param string $event    event to bind to, defaults to document
     * @param string $node     node to bind
     * @param bool   $wrap     if true, $funciton is wrappped in a function
     * @param int    $position sort order
     *
     * @return Scripts
     *
     * @access public
     */
    public function eventCaptureStart(
        $event = null,
        $node = null,
        $wrap = false,
        $position = 1000
    ) {
        $this->capture[] = [
            'func' => 'addEventListener',
            'args' => [
                $event,
                $node,
                $wrap,
                $position
            ]
        ];
        ob_start();
        return $this;
    }


    /**
     * end capture
     *
     * @return Scripts
     *
     * @access public
     */
    public function captureEnd()
    {
        $capture = array_pop($this->capture);
        array_unshift($capture['args'], ob_get_clean());
        call_user_func_array(
            [$this, $capture['func']],
            $capture['args']
        );
        return $this;
    }
}
