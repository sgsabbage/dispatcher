<?php
namespace SGS\Tests\Model;

use SGS\Model\Job;
use \Mockery as m;

class JobTest extends \PHPUnit_Framework_TestCase 
{

    private $job;

    public function setUp()
    {
        $this->job = new Job();
    }

    public function testIdIsNull()
    {
        $this->assertNull($this->job->getId());
    }

    public function testSetGetName()
    {
        $name = 'foo';
        $this->job->setName($name);

        $this->assertEquals($name,$this->job->getName());
    }

    public function testSetGetRequester()
    {
        $requester = m::mock('SGS\Model\User');
        $requester->shouldIgnoreMissing();

        $this->job->setRequester($requester);
        $this->assertSame($requester,$this->job->getRequester());
    }

    public function testSetRequesterNull()
    {
        $requester = m::mock('SGS\Model\User');
        $requester->shouldIgnoreMissing();

        $this->job->setRequester($requester);
        $this->job->setRequester();

        $this->assertNull($this->job->getRequester());
    }

    public function testSetRequesterAddsJob()
    {
        $requester = m::mock('SGS\Model\User');
        $requester->shouldIgnoreMissing();

        $requester->shouldReceive('addRequestedJob')->with($this->job,false)->once();

        $this->job->setRequester($requester);
    }

    public function testSetRequesterWithNoInverseDoesNotAddJob()
    {
        $requester = m::mock('SGS\Model\User');
        $requester->shouldIgnoreMissing();

        $requester->shouldReceive('addRequestedJob')->never();

        $this->job->setRequester($requester,false);
    }

    public function testSetNewRequesterRemovesJob()
    {
        $requester = m::mock('SGS\Model\User');
        $requester->shouldIgnoreMissing();
        $requester2 = m::mock('SGS\Model\User');
        $requester2->shouldIgnoreMissing();

        $requester->shouldReceive('removeRequestedJob')->with($this->job,false)->once();

        $this->job->setRequester($requester);   
        $this->job->setRequester($requester2);      
    }

    public function testSetNullRequesterRemovesJob()
    {
        $requester = m::mock('SGS\Model\User');
        $requester->shouldIgnoreMissing();

        $requester->shouldReceive('removeRequestedJob')->with($this->job,false)->once();

        $this->job->setRequester($requester);   
        $this->job->setRequester(null);
    }

}