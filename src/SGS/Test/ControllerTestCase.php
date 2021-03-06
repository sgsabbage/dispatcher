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
    protected $formFactory;
    protected $router;
    protected $flashBag;

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
            'Symfony\Component\HttpFoundation\Request'
        );
        $this->request->shouldIgnoreMissing();  

        $this->attributes = m::mock(
            'Symfony\Component\HttpFoundation\ParameterBag'
        );
        $this->attributes->shouldIgnoreMissing();

        $this->flashBag = m::mock(
            'Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface'
        );
        $this->flashBag->shouldIgnoreMissing();

        $this->session = m::mock(
            'Symfony\Component\HttpFoundation\Session\SessionInterface'
        );
        $this->session->shouldIgnoreMissing();

        $this->session->shouldReceive('getFlashBag')
            ->andReturn($this->flashBag);

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

        $this->formFactory = m::mock(
            'Symfony\Component\Form\formFactory'
        );
        $this->formFactory->shouldIgnoreMissing();

        $this->router = m::mock(
            'Symfony\Bundle\FrameworkBundle\Routing\Router'
        );
        $this->router->shouldIgnoreMissing();

        $this->container->shouldReceive('get')->with('session')
            ->andReturn($this->session);
            
        $this->container->shouldReceive('get')->with('request')
            ->andReturn($this->request);

        $this->container->shouldReceive('get')->with('router')
            ->andReturn($this->router);

        $this->container->shouldReceive('get')->with('security.context')
            ->andReturn($this->secContext);

        $this->container->shouldReceive('get')->with('doctrine')
            ->andReturn($this->doctrine);

        $this->container->shouldReceive('get')->with('form.factory')
            ->andReturn($this->formFactory);
    }
}