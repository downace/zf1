<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_View
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/**
 * Test class for Zend_View_Helper_FormButton.
 *
 * @category   Zend
 * @package    Zend_View
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @group      Zend_View
 * @group      Zend_View_Helper
 */
class Zend_View_Helper_FormButtonTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp(): void
    {
        $this->view = new Zend_View();
        $this->helper = new Zend_View_Helper_FormButton();
        $this->helper->setView($this->view);
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown(): void
    {
    }

    public function testFormButtonRendersButtonXhtml()
    {
        $button = $this->helper->formButton('foo', 'bar');
        $this->assertRegexp('/<button[^>]*?value="bar"/', $button);
        $this->assertRegexp('/<button[^>]*?name="foo"/', $button);
        $this->assertRegexp('/<button[^>]*?id="foo"/', $button);
        $this->assertStringContainsString('</button>', $button);
    }

    public function testCanPassContentViaContentAttribKey()
    {
        $button = $this->helper->formButton('foo', 'bar', array('content' => 'Display this'));
        $this->assertStringContainsString('>Display this<', $button);
        $this->assertStringContainsString('<button', $button);
        $this->assertStringContainsString('</button>', $button);
    }

    public function testCanDisableContentEscaping()
    {
        $button = $this->helper->formButton('foo', 'bar', array('content' => '<b>Display this</b>', 'escape' => false));
        $this->assertStringContainsString('><b>Display this</b><', $button);

        $button = $this->helper->formButton(array('name' => 'foo', 'value' => 'bar', 'attribs' => array('content' => '<b>Display this</b>', 'escape' => false)));
        $this->assertStringContainsString('><b>Display this</b><', $button);

        $button = $this->helper->formButton(array('name' => 'foo', 'value' => 'bar', 'escape' => false, 'attribs' => array('content' => '<b>Display this</b>')));
        $this->assertStringContainsString('><b>Display this</b><', $button);
        $this->assertStringContainsString('<button', $button);
        $this->assertStringContainsString('</button>', $button);
    }

    public function testValueUsedForContentWhenNoContentProvided()
    {
        $button = $this->helper->formButton(array('name' => 'foo', 'value' => 'bar'));
        $this->assertRegexp('#<button[^>]*?value="bar"[^>]*>bar</button>#', $button);
    }

    public function testButtonTypeIsButtonByDefault()
    {
        $button = $this->helper->formButton(array('name' => 'foo', 'value' => 'bar'));
        $this->assertStringContainsString('type="button"', $button);
    }

    public function testButtonTypeMayOnlyBeValidXhtmlButtonType()
    {
        $button = $this->helper->formButton(array('name' => 'foo', 'value' => 'bar', 'attribs' => array('type' => 'submit')));
        $this->assertStringContainsString('type="submit"', $button);
        $button = $this->helper->formButton(array('name' => 'foo', 'value' => 'bar', 'attribs' => array('type' => 'reset')));
        $this->assertStringContainsString('type="reset"', $button);
        $button = $this->helper->formButton(array('name' => 'foo', 'value' => 'bar', 'attribs' => array('type' => 'button')));
        $this->assertStringContainsString('type="button"', $button);
        $button = $this->helper->formButton(array('name' => 'foo', 'value' => 'bar', 'attribs' => array('type' => 'bogus')));
        $this->assertStringContainsString('type="button"', $button);
    }
}
