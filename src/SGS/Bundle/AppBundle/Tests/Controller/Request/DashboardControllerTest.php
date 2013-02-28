<?php
namespace SGS\Bundle\AppBundle\Tests\Controller\Request;

use Mockery as m;
use SGS\Bundle\AppBundle\Controller\Request\DashboardController;
use SGS\Test\ControllerTestCase;
use Doctrine\Common\Collections\ArrayCollection;

class DashboardControllerTest extends ControllerTestCase {
    
    protected $controller;

    public function setUp()
    {
        $this->setUpContainer();

        $this->controller = new DashboardController();

        $this->controller->setContainer($this->container);
    }

    public function testIndexReturnsLoggedInUsersJobs()
    {
        $jobs = new ArrayCollection();

        $repo = m::mock('Doctrine\ORM\EntityRepository');

        $this->em->shouldReceive('getRepository')
            ->with('Model:Job')->andReturn($repo);

        $repo->shouldReceive('findByRequester')
            ->with($this->user)->andReturn($jobs);

        $response = $this->controller->indexAction();

        $this->assertSame(
            $jobs,
            $response['jobs']
        );
    }
}