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
}