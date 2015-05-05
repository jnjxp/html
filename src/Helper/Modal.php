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
 * Bootstrap Modal window
 *
 * A Bootstrap modal window.
 *
 * @category Helper
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 * @see      AbstractHelper
 */
class Modal extends AbstractHelper
{
    /**
     * effect class name
     *
     * @var string
     * @access protected
     */
    protected $effect = 'fade';

    /**
     * tag to use for modal title
     *
     * @var string
     * @access protected
     */
    protected $titleTag = 'h4';

    /**
     * properties to build button from
     *
     * @var array
     * @access protected
     */
    protected $button = array();

    /**
     * attributes for modal
     *
     * @var array | null
     * @access protected
     */
    protected $attr;

    /**
     * title of modal window
     *
     * @var string
     * @access protected
     */
    protected $title;

    /**
     * html for modal body
     *
     * @var string
     * @access protected
     */
    protected $body;

    /**
     * modal footer html
     *
     * @var string
     * @access protected
     */
    protected $footer;

    /**
     * html
     *
     * @var string
     * @access protected
     */
    protected $html = '';

    /**
     * sets modal spec
     *
     * @param null|array $spec array of properties to pass to setters
     *
     * @return Modal
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
     * build modal html
     *
     * @return string
     *
     * @access public
     */
    public function __toString()
    {
        if (null === $this->attr) {
            $this->setAttr([]);
        }

        $modalId = $this->attr['id'];

        if (! empty($this->button)) {
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
        $this->html .= $this->indent(1, '</div>');
        $this->html .= $this->indent(0, '</div>');

        $html = $this->html;

        $this->resetProperties();

        return $html;
    }

    /**
     * reset properties of modal
     *
     * @return void
     *
     * @access protected
     */
    protected function resetProperties()
    {
        $this->effect   = 'fade';
        $this->titleTag = 'h4';
        $this->button   = [];
        $this->attr     = [];
        $this->title    = null;
        $this->body     = null;
        $this->footer   = null;
        $this->html     = '';
    }

    /**
     * build modal launch button
     *
     * @return void
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
     * build modal header
     *
     * @return void
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
     * build modal body
     *
     * @return void
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
     * build modal footer if set
     *
     * @return void
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
     * set modal title string
     *
     * @param string $title title of modal
     *
     * @return Modal
     *
     * @access public
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * set tag used for modal title
     *
     * @param string $tag html tag name
     *
     * @return Modal
     *
     * @access public
     */
    public function setTitleTag($tag)
    {
        $this->titleTag = $tag;
        return $this;
    }

    /**
     * set modal body html
     *
     * @param string $body modal body html
     *
     * @return Modal
     *
     * @access public
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * set modal footer html
     *
     * @param string $footer modal footer html
     *
     * @return Modal
     *
     * @access public
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
        return $this;
    }

    /**
     * set effect
     *
     * @param string $effect effect class to add
     *
     * @return Modal
     *
     * @access public
     */
    public function setEffect($effect)
    {
        $this->effect = $effect;
        return $this;
    }

    /**
     * set button properties
     *
     * @param string $content content of button
     * @param array  $attr    button attributes
     *
     * @return Modal
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
     * set modal attributes. Auto generate id if not present
     *
     * @param array $attr modal attirbutes
     *
     * @return Modal
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
     * set modal specs. Call setters based on array.
     *
     * @param array $spec array specification
     *
     * @return Modal
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
