<?php
namespace SGS\Bundle\AppBundle\Tests\Controller\Dispatch;

use Symfony\Component\Security\Core\SecurityContext;

use SGS\Bundle\AppBundle\Controller\Dispatch\LoginController;
use SGS\Test\ControllerTestCase;

class LoginControllerTest extends ControllerTestCase
{
    protected $controller;

    public function setUp()
    {
        $this->setUpContainer();

        $this->controller = new LoginController();

        $this->controller->setContainer($this->container);
    }

    public function testFirstLoginReturnsEmptyKeys()
    {
        $this->attributes->shouldReceive('has')->with(SecurityContext::AUTHENTICATION_ERROR)->andReturn(false);
        $this->session->shouldReceive('get')->with(SecurityContext::AUTHENTICATION_ERROR)->andReturn(null);
        $this->session->shouldReceive('get')->with(SecurityContext::LAST_USERNAME)->andReturn(null);
        
        $expected = array(
            'last_email' => null,
            'error' => null
        );

        $response = $this->controller->loginAction();

        $this->assertEquals($expected,$response);
    }

    public function testLoginErrorInSessionIsReturned()
    {
        $error = 'error';

        $this->attributes->shouldReceive('has')->with(SecurityContext::AUTHENTICATION_ERROR)->andReturn(false);
        $this->session->shouldReceive('get')->with(SecurityContext::AUTHENTICATION_ERROR)->andReturn($error);
        $this->session->shouldReceive('get')->with(SecurityContext::LAST_USERNAME)->andReturn(null);

        $response = $this->controller->loginAction();

        $this->assertEquals($error,$response['error']);
    }

    public function testLoginErrorInRequestIsReturned()
    {
        $error = 'error';

        $this->attributes->shouldReceive('has')->with(SecurityContext::AUTHENTICATION_ERROR)->andReturn(true);
        $this->attributes->shouldReceive('get')->with(SecurityContext::AUTHENTICATION_ERROR)->andReturn($error);

        $response = $this->controller->loginAction();

        $this->assertEquals($error,$response['error']);
    }

    public function testLastEmailInSessionIsReturned()
    {
        $email = 'email';

        $this->session->shouldReceive('get')->with(SecurityContext::LAST_USERNAME)->andReturn($email);

        $response = $this->controller->loginAction();

        $this->assertEquals($email,$response['last_email']);
    }

    public function testDeniedActionReturnsEmptyArray()
    {
        $this->assertEquals(
            array(),
            $this->controller->deniedAction()
        );
    }
}