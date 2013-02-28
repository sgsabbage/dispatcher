<?php
namespace SGS\Test;

use \Mockery as m;

class ControllerTestCase extends \PHPUnit_Framework_TestCase {
    
    protected $container;
    protected $controller;
    protected $request;
    protected $attributes;
    protected $session;

    public function setUpContainer()
    {
        $this->container = m::mock(
            'Symfony\Component\DependencyInjection\Container'
        );
        $this->container->shouldIgnoreMissing();

        $this->request = m::mock(
            'Symfony\Component\DependencyInjection\Request'
        );
        $this->request->shouldIgnoreMissing();  

        $this->attributes = m::mock(
            'Symfony\Component\HttpFoundation\ParameterBag'
        );

        $this->attributes->shouldIgnoreMissing();

        $this->session = m::mock(
            'Symfony\Component\HttpFoundation\Session\SessionInterface'
        );
        $this->session->shouldIgnoreMissing();

        $this->request->attributes = $this->attributes;
        $this->request->shouldReceive('getSession')
            ->andReturn($this->session);

        $this->container->shouldReceive('get')->with('request')
            ->andReturn($this->request);
    }
}