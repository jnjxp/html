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

use Aura\Html\Helper\AbstractHelper;

/**
 * Modal
 *
 * Description Here!
 *
 * @category CategoryName
 * @package  PackageName
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 * @see      AbstractHelper
 */
class Modal extends AbstractHelper
{
    protected $effect = 'fade';

    protected $titleTag = 'h4';

    protected $button;

    protected $attr;

    protected $title;

    protected $body;

    protected $footer;

    protected $html = '';

    /**
     * __invoke
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param array $spec DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function __invoke(array $spec = null)
    {
        if ($spec !== null) {
            $this->setSpec($spec);
        }
        return $this;
    }

    /**
     * __toString
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @return mixed
     *
     * @access public
     */
    public function __toString()
    {
        if (null === $this->attr) {
            $this->setAttr([]);
        }

        $modalId = $this->attr['id'];

        if ($this->button) {
            $this->buildButton();
        }

        $attr = $this->escaper->attr(
            array_merge_recursive(
                $this->attr,
                [
                    'class'           => ['modal', $this->effect],
                    'tabindex'        => '-1',
                    'role'            => 'dialog',
                    'aria-labelledby' => "{$modalId}-label",
                    'aria-hidden'     => 'true'
                ]
            )
        );


        $this->html .= $this->indent(0, "<div $attr>");
        $this->html .= $this->indent(1, '<div class="modal-dialog">');
        $this->html .= $this->indent(2, '<div class="modal-content">');
        $this->buildHeader();
        $this->buildBody();
        $this->buildFooter();
        $this->html .= $this->indent(2, '</div>');
        $this->html .= $this->indent(1, "</div>");
        $this->html .= $this->indent(0, "</div>");

        $html = $this->html;

        $this->resetProperties();

        return $html;
    }

    /**
     * resetProperties
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access protected
     */
    protected function resetProperties()
    {
        $this->effect   = 'fade';
        $this->titleTag = 'h4';
        $this->button   = null;
        $this->attr     = [];
        $this->title    = null;
        $this->body     = null;
        $this->footer   = null;
        $this->html     = '';
    }

    /**
     * renderButton
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access protected
     */
    protected function buildButton()
    {
        list($content, $attr) = $this->button;

        $mid = $this->attr['id'];

        $attr = $this->escaper->attr(
            array_merge_recursive(
                $attr,
                [
                    'type'        => 'button',
                    'data-toggle' => 'modal',
                    'data-target' => "#{$mid}"
                ]
            )
        );

        $this->html .= $this->indent(0, "<button $attr>");
        $this->html .= $this->indent(1, $content);
        $this->html .= $this->indent(0, '</button>');
    }

    /**
     * renderHeader
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access protected
     */
    protected function buildHeader()
    {
        $close = '<button type="button" class="close" data-dismiss="modal" '
            . 'aria-label="Close"><span aria-hidden="true">&times;</span></button>';


        $tag = $this->titleTag;
        $tid = $this->attr['id'] . '-label';
        $ttl = $this->title;

        $title = "<${tag} class=\"modal-title\" id=\"$tid\">{$ttl}</{$tag}>";

        $this->html .= $this->indent(3, '<div class="modal-header">');
        $this->html .= $this->indent(4, $close);
        $this->html .= $this->indent(4, $title);
        $this->html .= $this->indent(3, '</div>');
    }

    /**
     * renderBody
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access protected
     */
    protected function buildBody()
    {
        $this->html .= $this->indent(3, '<div class="modal-body">');
        $this->html .= $this->indent(4, $this->body);
        $this->html .= $this->indent(3, '</div>');
    }

    /**
     * renderFooter
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access protected
     */
    protected function buildFooter()
    {
        if (! $this->footer) {
            return;
        }

        $this->html .= $this->indent(3, '<div class="modal-footer">');
        $this->html .= $this->indent(4, $this->footer);
        $this->html .= $this->indent(3, '</div>');
    }

    /**
     * setTitle
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $title DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * setTitleTag
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $tag DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function setTitleTag($tag)
    {
        $this->titleTag = $tag;
        return $this;
    }

    /**
     * setBody
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $body DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * setFooter
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $footer DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
        return $this;
    }

    /**
     * setEffect
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $effect DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function setEffect($effect)
    {
        $this->effect = $effect;
        return $this;
    }

    /**
     * setButton
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param mixed $content DESCRIPTION
     * @param array $attr    DESCRIPTION
     *
     * @return mixed
     *
     * @access public
     */
    public function setButton($content, array $attr = [])
    {
        if (is_array($content)) {
            $attr = $content[1];
            $content = $content[0];
        }

        $this->button = [
            $content, $attr
        ];

        return $this;
    }

    /**
     * setAttr
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param array $attr DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function setAttr(array $attr)
    {
        $this->attr = array_merge(
            ['id' => uniqid('modal_')],
            $attr
        );
        return $this;
    }

    /**
     * setSpec
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * @param array $spec DESCRIPTION
     *
     * @return mixed
     * @throws exceptionclass [description]
     *
     * @access public
     */
    public function setSpec(array $spec)
    {
        foreach ($spec as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        return $this;
    }
}
