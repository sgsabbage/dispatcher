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
        $this->user->setType(User::TYPE_ENGINEER);
        $this->assertEquals(User::TYPE_ENGINEER,$this->user->getType());
    }
}