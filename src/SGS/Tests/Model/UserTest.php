<?php
namespace SGS\Tests\Model;

use SGS\Model\User;

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
}