<?php
namespace SGS\Bundle\AppBundle\Tests\Controller\Admin;

use \Mockery as m;
use Symfony\Component\Security\Core\SecurityContext;

use SGS\Bundle\AppBundle\Controller\Admin\LoginController;

class LoginControllerTest extends \PHPUnit_Framework_TestCase
{
    protected $container;
    protected $controller;
    protected $request;
    protected $attributes;
    protected $session;

    public function setUp()
    {
        $this->controller = new LoginController();

        $this->container = m::mock('Symfony\Component\DependencyInjection\Container');
        $this->container->shouldIgnoreMissing();

        $this->request = m::mock('Symfony\Component\DependencyInjection\Request');
        $this->request->shouldIgnoreMissing();  

        $this->attributes = m::mock('Symfony\Component\HttpFoundation\ParameterBag');
        $this->attributes->shouldIgnoreMissing();

        $this->session = m::mock('Symfony\Component\HttpFoundation\Session\SessionInterface');
        $this->session->shouldIgnoreMissing();

        $this->request->attributes = $this->attributes;
        $this->request->shouldReceive('getSession')->andReturn($this->session);

        $this->container->shouldReceive('get')->with('request')->andReturn($this->request);

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