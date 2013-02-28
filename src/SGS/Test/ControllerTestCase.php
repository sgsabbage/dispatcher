<?php
namespace SGS\Test;

use \Mockery as m;

class ControllerTestCase extends \PHPUnit_Framework_TestCase {
    
    protected $container;
    protected $controller;
    protected $request;
    protected $attributes;
    protected $session;
    protected $secContext;
    protected $user;
    protected $doctrine;
    protected $em;

    public function setUpContainer()
    {
        $this->container = m::mock(
            'Symfony\Component\DependencyInjection\Container'
        );
        $this->container->shouldIgnoreMissing();

        $this->user = m::mock(
            'SGS\Model\User'
        );
        $this->user->shouldIgnoreMissing();

        $this->secContext = m::mock(
            'Symfony\Component\Security\Core\SecurityContextInterface'
        );
        $this->secContext->shouldIgnoreMissing();
        $this->secContext->shouldReceive('getToken->getUser')
            ->andReturn($this->user);

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

        $this->em = m::mock(
            'Doctrine\ORM\EntityManager'
        );
        $this->em->shouldIgnoreMissing();

        $this->doctrine = m::mock(
            'Doctrine\Bundle\DoctrineBundle\Registry'
        );
        $this->doctrine->shouldIgnoreMissing();
        $this->doctrine->shouldReceive('getEntityManager')
            ->andReturn($this->em);

        $this->request->attributes = $this->attributes;
        $this->request->shouldReceive('getSession')
            ->andReturn($this->session);

        $this->container->shouldReceive('get')->with('request')
            ->andReturn($this->request);

        $this->container->shouldReceive('get')->with('security.context')
            ->andReturn($this->secContext);

        $this->container->shouldReceive('get')->with('doctrine')
            ->andReturn($this->doctrine);
    }
}