<?php
namespace SGS\Tests\Model;

use SGS\Model\User;
use \Mockery as m;

class UserTest extends \PHPUnit_Framework_TestCase 
{
    protected $user;

    public function setUp()
    {
        $this->user = new User();
    }

    public function testIdIsNull()
    {
        $this->assertNull($this->user->getId());
    }

    public function testSetGetEmail()
    {
        $email = 'foo@foo.com';
        $this->user->setEmail($email);
        $this->assertEquals($email,$this->user->getEmail());
    }

    public function testEmailIsUsername()
    {
        $email = 'foo@foo.com';
        $this->user->setEmail($email);
        $this->assertEquals($email,$this->user->getUsername());
    }

    public function testSetGetPassword()
    {
        $password = "Pass";
        $this->user->setPassword($password);
        $this->assertEquals($password,$this->user->getPassword());
    }

    public function testSaltIsNotNull()
    {
        $this->assertNotNull($this->user->getSalt());
    }

    public function testSetGetType()
    {
        $this->user->setType(User::TYPE_AGENT);
        $this->assertEquals(User::TYPE_AGENT,$this->user->getType());
    }

    public function testAddType()
    {
        $this->user->setType(User::TYPE_AGENT);
        $this->user->addType(User::TYPE_DISPATCHER);
        $this->assertEquals(User::TYPE_AGENT | User::TYPE_DISPATCHER, $this->user->getType());
    }

    public function testAddTypeWhenAlreadySet()
    {
        $this->user->setType(User::TYPE_AGENT);
        $this->user->addType(User::TYPE_DISPATCHER);
        $this->user->addType(User::TYPE_DISPATCHER);
        $this->assertEquals(User::TYPE_AGENT | User::TYPE_DISPATCHER, $this->user->getType());
    }

    public function testRemoveType()
    {
        $this->user->setType(User::TYPE_AGENT | User::TYPE_DISPATCHER);
        $this->user->removeType(User::TYPE_DISPATCHER);
        $this->assertEquals(User::TYPE_AGENT, $this->user->getType());
    }

    public function testRemoveTypeWhenAlreadyRemoved()
    {
        $this->user->setType(User::TYPE_AGENT | User::TYPE_DISPATCHER);
        $this->user->removeType(User::TYPE_DISPATCHER);
        $this->user->removeType(User::TYPE_DISPATCHER);
        $this->assertEquals(User::TYPE_AGENT, $this->user->getType());
    }

    public function testHasTypeWhenTrue()
    {
        $this->user->setType(User::TYPE_AGENT);
        $this->assertTrue($this->user->hasType(User::TYPE_AGENT));
    }

    public function testHasTypeWhenTrueWithMultipleTypes()
    {
        $this->user->setType(User::TYPE_AGENT | User::TYPE_DISPATCHER);
        $this->assertTrue($this->user->hasType(User::TYPE_AGENT));
    }

    public function testHasTypeWhenFalse()
    {
        $this->user->setType(User::TYPE_DISPATCHER);
        $this->assertFalse($this->user->hasType(User::TYPE_AGENT));
    }

    public function testGetRequestedJobsIsBlankByDefault()
    {
        $this->assertTrue($this->user->getRequestedJobs()->isEmpty());
    }

    public function testAddingANewRequestedJobAddsToCollections()
    {
        $job = m::mock('SGS\Model\Job');
        $job->shouldIgnoreMissing();

        $this->user->addRequestedJob($job);

        $this->assertTrue($this->user->getRequestedJobs()->contains($job));
    }

    public function testRemovingARequestedJobRemovesFromCollection()
    {
        $job = m::mock('SGS\Model\Job');
        $job->shouldIgnoreMissing();

        $this->user->addRequestedJob($job);
        $this->user->removeRequestedJob($job);

        $this->assertFalse($this->user->getRequestedJobs()->contains($job));
    }

    public function testAddingARequestedJobTwiceOnlyResultsInOneJob()
    {
        $job = m::mock('SGS\Model\Job');
        $job->shouldIgnoreMissing();

        $this->user->addRequestedJob($job);
        $this->user->addRequestedJob($job);

        $this->assertEquals(1,$this->user->getRequestedJobs()->count());
    }

    public function testAddingARequestedJobSetsRequester()
    {
        $job = m::mock('SGS\Model\Job');
        $job->shouldIgnoreMissing();

        $job->shouldReceive('setRequester')->with($this->user,false)->once();

        $this->user->addRequestedJob($job);
    }

    public function testRemovingARequestedJobSetsRequesterNull()
    {
        $job = m::mock('SGS\Model\Job');
        $job->shouldIgnoreMissing();

        $job->shouldReceive('setRequester')->with($this->user,false);
        $job->shouldReceive('setRequester')->with(null, false)->once();

        $this->user->addRequestedJob($job);
        $this->user->removeRequestedJob($job);
    }

    public function testAddingARequestedJobWithCallInverseFalseDoesNotSetRequester()
    {
        $job = m::mock('SGS\Model\Job');
        $job->shouldIgnoreMissing();

        $job->shouldReceive('setRequester')->never();

        $this->user->addRequestedJob($job, false);
    }

     public function testRemovingARequestedJobWithCallInverseFalseDoesNotSetRequester()
    {
        $job = m::mock('SGS\Model\Job');
        $job->shouldIgnoreMissing();

        $job->shouldReceive('setRequester')->with($this->user,false);
        $job->shouldReceive('setRequester')->with(null,false)->never();

        $this->user->addRequestedJob($job);
        $this->user->removeRequestedJob($job, false);
    }
}