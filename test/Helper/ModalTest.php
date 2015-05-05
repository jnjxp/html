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
* @category  Test
* @package   Jnjxp\Html
* @author    Jake Johns <jake@jakejohns.net>
* @copyright 2015 Jake Johns
* @license   http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
* @link      http://jakejohns.net
 */

namespace JnjxpTest\Html\Helper;

use ReflectionClass;

/**
 * Modal Test
 *
 * @category Test
 * @package  Jnjxp\Html
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 * @see      PHPUnit_Framework_TestCase
 */
class ModalTest extends AbstractHelperTest
{

    /**
     * helper makes basic modal
     *
     * @return void
     *
     * @access public
     */
    public function testBasicModal()
    {
        $helper = $this->helper;
        $helper(
            [
                'effect' => false,
                'titleTag' => 'h1',
                'button' => ['button', ['class' => 'button1']],
                'attr' => ['id' => 'modal1'],
                'title' => 'Title',
                'body' => 'body',
                'footer' => 'footer'
            ]
        );

        $expect = '<button class="button1" type="button" data-toggle="modal" '
            . 'data-target="#modal1">'
            . PHP_EOL
            . '    button'
            . PHP_EOL
            . '</button>'
            . PHP_EOL
            . '<div id="modal1" class="modal " tabindex="-1" role="dialog" '
            . 'aria-labelledby="modal1-label" aria-hidden="true">'
            . PHP_EOL
            . '    <div class="modal-dialog">'
            . PHP_EOL
            . '        <div class="modal-content">'
            . PHP_EOL
            . '            <div class="modal-header">'
            . PHP_EOL
            . '                <button type="button" class="close" '
            . 'data-dismiss="modal" aria-label="Close">'
            . '<span aria-hidden="true">&times;</span></button>'
            . PHP_EOL
            . '                <h1 class="modal-title" id="modal1-label">Title</h1>'
            . PHP_EOL
            . '            </div>'
            . PHP_EOL
            . '            <div class="modal-body">'
            . PHP_EOL
            . '                body'
            . PHP_EOL
            . '            </div>'
            . PHP_EOL
            . '            <div class="modal-footer">'
            . PHP_EOL
            . '                footer'
            . PHP_EOL
            . '            </div>'
            . PHP_EOL
            . '        </div>'
            . PHP_EOL
            . '    </div>'
            . PHP_EOL
            . '</div>'
            . PHP_EOL;

        $actual = "$helper";
        $this->assertSame($expect, $actual);
    }

    /**
     * test modal without footer
     *
     * @return void
     *
     * @access public
     */
    public function testFooterless()
    {

        $helper = $this->helper;
        $helper(
            [
                'effect' => false,
                'titleTag' => 'h1',
                'button' => ['button', ['class' => 'button1']],
                'attr' => ['id' => 'modal1'],
                'title' => 'Title',
                'body' => 'body',
            ]
        );

        $expect = '<button class="button1" type="button" data-toggle="modal" '
            . 'data-target="#modal1">'
            . PHP_EOL
            . '    button'
            . PHP_EOL
            . '</button>'
            . PHP_EOL
            . '<div id="modal1" class="modal " tabindex="-1" role="dialog" '
            . 'aria-labelledby="modal1-label" aria-hidden="true">'
            . PHP_EOL
            . '    <div class="modal-dialog">'
            . PHP_EOL
            . '        <div class="modal-content">'
            . PHP_EOL
            . '            <div class="modal-header">'
            . PHP_EOL
            . '                <button type="button" class="close" '
            . 'data-dismiss="modal" aria-label="Close">'
            . '<span aria-hidden="true">&times;</span></button>'
            . PHP_EOL
            . '                <h1 class="modal-title" id="modal1-label">Title</h1>'
            . PHP_EOL
            . '            </div>'
            . PHP_EOL
            . '            <div class="modal-body">'
            . PHP_EOL
            . '                body'
            . PHP_EOL
            . '            </div>'
            . PHP_EOL
            . '        </div>'
            . PHP_EOL
            . '    </div>'
            . PHP_EOL
            . '</div>'
            . PHP_EOL;

        $actual = "$helper";
        $this->assertSame($expect, $actual);
    }

    /**
     * test modal with auto generated id
     *
     * @return void
     *
     * @access public
     */
    public function testAutoId()
    {

        $helper = $this->helper;
        $helper(
            [
                'effect' => false,
                'titleTag' => 'h1',
                'button' => ['button', ['class' => 'button1']],
                'title' => 'Title',
                'body' => 'body',
            ]
        );

        $actual = "$helper";
        $str = strtok($actual, "\n");
        $uid = substr($str, 72, -2);


        $expect = '<button class="button1" type="button" data-toggle="modal" '
            . 'data-target="#' . $uid . '">'
            . PHP_EOL
            . '    button'
            . PHP_EOL
            . '</button>'
            . PHP_EOL
            . '<div id="' . $uid . '" class="modal " tabindex="-1" role="dialog" '
            . 'aria-labelledby="' . $uid . '-label" aria-hidden="true">'
            . PHP_EOL
            . '    <div class="modal-dialog">'
            . PHP_EOL
            . '        <div class="modal-content">'
            . PHP_EOL
            . '            <div class="modal-header">'
            . PHP_EOL
            . '                <button type="button" class="close" '
            . 'data-dismiss="modal" aria-label="Close">'
            . '<span aria-hidden="true">&times;</span></button>'
            . PHP_EOL
            . '                <h1 class="modal-title" id="' . $uid
            . '-label">Title</h1>'
            . PHP_EOL
            . '            </div>'
            . PHP_EOL
            . '            <div class="modal-body">'
            . PHP_EOL
            . '                body'
            . PHP_EOL
            . '            </div>'
            . PHP_EOL
            . '        </div>'
            . PHP_EOL
            . '    </div>'
            . PHP_EOL
            . '</div>'
            . PHP_EOL;

        $this->assertSame($expect, $actual);
    }
}
