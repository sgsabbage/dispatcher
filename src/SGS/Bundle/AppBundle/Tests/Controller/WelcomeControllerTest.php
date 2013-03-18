<?php
namespace SGS\Bundle\AppBundle\Tests\Controller;

use SGS\Bundle\AppBundle\Controller\WelcomeController;
use SGS\Test\ControllerTestCase;

class LoginControllerTest extends ControllerTestCase
{
    public function setUp()
    {
        $this->setUpContainer();

        $this->controller = new WelcomeController();

        $this->controller->setContainer($this->container);
    }

    public function testWelcomeControllerReturnsEmptyArray()
    {
        $this->assertEquals(
            array(),
            $this->controller->indexAction()
        );
    }
}