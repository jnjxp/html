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
 * Scripts
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
     * capture
     *
     * @var mixed
     * @access protected
     */
    protected $capture = [];

    /**
     * addInline
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $script   DESCRIPTION
     * @param int   $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
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
     * addEventListenerFunction
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed  $function DESCRIPTION
     * @param string $event    DESCRIPTION
     * @param int    $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function addEventListenerFunction($function, $event, $position = 1000)
    {
        $this->addInline(
            "document.addEventListener(\"{$event}\", {$function});",
            $position
        );
        return $this;
    }

    /**
     * addLoadedListenerFunction
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $function DESCRIPTION
     * @param int   $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function addLoadedListenerFunction($function, $position = 1000)
    {
        $this->addEventListenerFunction($function, 'DOMContentLoaded', $position);
        return $this;
    }

    /**
     * addEventListener
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed  $script   DESCRIPTION
     * @param string $event    DESCRIPTION
     * @param int    $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function addEventListener($script, $event, $position = 1000)
    {
        $function = "function(event) { {$script} }";
        $this->addEventListenerFunction($event, $function, $position);
        return $this;
    }

    /**
     * addLoadedListener
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $script   DESCRIPTION
     * @param int   $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function addLoadedListener($script, $position = 1000)
    {
        $this->addEventListener($script, 'DOMContentLoaded', $position);
        return $this;
    }

    /**
     * inlineCaptureStart
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param int $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
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
    }

    /**
     * inlineCaptureEnd
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param string $event    DESCRIPTION
     * @param int    $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function eventCaptureStart($event, $position = 1000)
    {
        $this->capture[] = [
            'func' => 'addEventListener',
            'args' => [
                $event,
                $position
            ]
        ];
        ob_start();
    }

    /**
     * inlineCaptureLoadedEnd
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param int $position DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function loadedCaptureStart($position = 1000)
    {
        $this->capture[] = [
            'func' => 'addEventListener',
            'args' => [
                'DOMContentLoaded',
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
    public function captureEnd()
    {
        $capture = array_pop($this->capture);
        array_unshift($capture['args'], ob_get_clean());
        call_user_func_array(
            [$this, $capture['func']],
            $capture['args']
        );
    }
}
