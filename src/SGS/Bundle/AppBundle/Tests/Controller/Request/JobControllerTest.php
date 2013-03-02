<?php
namespace SGS\Bundle\AppBundle\Tests\Controller\Request;

use SGS\Test\ControllerTestCase;
use SGS\Bundle\AppBundle\Controller\Request\JobController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use SGS\Model\Job;
use Mockery as m;

class JobControllerTest extends ControllerTestCase
{
    protected $controller;

    public function setUp()
    {
        $this->setUpContainer();

        $this->controller = new JobController();

        $this->controller->setContainer($this->container);

        $this->router->shouldReceive('generate')->andReturn('foo');
    }

    public function testNewActionReturnsFormAndEntity()
    {
        $form = "foo";
        
        $formBuilder = m::mock('Symfony\Component\Form\FormBuilder');
        $formBuilder->shouldReceive('createView')->andReturn($form);
        $this->formFactory->shouldReceive('create')
            ->with(
                m::type('SGS\Bundle\AppBundle\Form\Request\Job\NewType'),
                m::type('SGS\Model\Job')
            )
            ->andReturn($formBuilder);

        $response = $this->controller->newAction();

        $this->assertSame($form,$response['form']);
        $this->assertTrue($response['entity'] instanceof Job);
    }

    public function testIfNewFormIsValidEntityIsSaved()
    {
        $formBuilder = m::mock('Symfony\Component\Form\FormBuilder');
        $formBuilder->shouldIgnoreMissing();

        $formBuilder->shouldReceive('isValid')->andReturn(true);
        $this->formFactory->shouldReceive('create')
            ->with(
                m::type('SGS\Bundle\AppBundle\Form\Request\Job\NewType'),
                m::type('SGS\Model\Job')
            )
            ->andReturn($formBuilder);

        $this->em->shouldReceive('persist')->with(m::type('SGS\Model\Job'))->once();
        $this->em->shouldReceive('flush')->once();

        $this->controller->createAction($this->request);
    }

    public function testIfNewFormIsValidRedirectIsReturned()
    {
        $formBuilder = m::mock('Symfony\Component\Form\FormBuilder');
        $formBuilder->shouldIgnoreMissing();

        $formBuilder->shouldReceive('isValid')->andReturn(true);
        $this->formFactory->shouldReceive('create')
            ->with(
                m::type('SGS\Bundle\AppBundle\Form\Request\Job\NewType'),
                m::type('SGS\Model\Job')
            )
            ->andReturn($formBuilder);

        $response = $this->controller->createAction($this->request);

        $this->assertTrue($response instanceOf RedirectResponse);
    }


    public function testIfNewFormIsInvalidEntityAndFormAreReturned()
    {
        $form = "foo";

        $formBuilder = m::mock('Symfony\Component\Form\FormBuilder');
        $formBuilder->shouldIgnoreMissing();

        $formBuilder->shouldReceive('createView')->andReturn($form);
        $formBuilder->shouldReceive('isValid')->andReturn(false);
        $this->formFactory->shouldReceive('create')
            ->with(
                m::type('SGS\Bundle\AppBundle\Form\Request\Job\NewType'),
                m::type('SGS\Model\Job')
            )
            ->andReturn($formBuilder);

        $response = $this->controller->createAction($this->request);

        $this->assertTrue($response['entity'] instanceof Job);
        $this->assertSame($form,$response['form']);
    }

    public function testShowActionReturnsEntityIfUsersJob()
    {
        $entity = m::mock('SGS\Model\Job');
        $entity->shouldReceive('getRequester')->andReturn($this->user);
        $response = $this->controller->showAction($entity);

        $this->assertSame($entity,$response['entity']);
    }

    public function testShowActionReturnsRedirectIfNotUsersJob()
    {
        $entity = m::mock('SGS\Model\Job');
        $someoneElse = m::mock('SGS\Model\User');
        
        $entity->shouldReceive('getRequester')->andReturn($someoneElse);
        $response = $this->controller->showAction($entity);

        $this->assertTrue($response instanceOf RedirectResponse);
    }
}