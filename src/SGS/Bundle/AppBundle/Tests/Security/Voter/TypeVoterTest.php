<?php
namespace SGS\Bundle\AppBundle\Tests\Security\Voter;

use SGS\Bundle\AppBundle\Security\Voter\TypeVoter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

use \Mockery as m;

class TypeVoterTest extends \PHPUnit_Framework_TestCase
{
    protected $voter;

    public function setUp()
    {
        $this->voter = new TypeVoter();
    }

    public function testSupportsTypeAttribute()
    {
        $this->assertTrue($this->voter->supportsAttribute('TYPE_FOO'));
    }

    public function testDoesNotSupportRoleAttribute()
    {
        $this->assertFalse($this->voter->supportsAttribute('ROLE_FOO'));
    }

    public function testSupportsAllClasses()
    {
        $this->assertTrue($this->voter->supportsClass('foo'));
    }

    public function testVoteGrantedWhenHasType()
    {
        $user = $this->getUser();
        $token = $this->getUserToken($user);

        $user->shouldReceive('hasType')->with(\SGS\Model\User::TYPE_AGENT)->andReturn(true);

        $this->assertEquals(
            VoterInterface::ACCESS_GRANTED,
            $this->voter->vote($token,null,array('TYPE_AGENT'))
        );
    }

    public function testVoteDeniedWhenDoesNotHaveType()
    {
        $user = $this->getUser();
        $token = $this->getUserToken($user);

        $user->shouldReceive('hasType')->with(\SGS\Model\User::TYPE_AGENT)->andReturn(false);

        $this->assertEquals(
            VoterInterface::ACCESS_DENIED,
            $this->voter->vote($token,null,array('TYPE_AGENT'))
        );
    }

    public function testVoteDeniedWhenTypeDoesNotExist()
    {
        $user = $this->getUser();
        $token = $this->getUserToken($user);

        $this->assertEquals(
            VoterInterface::ACCESS_DENIED,
            $this->voter->vote($token,null,array('TYPE_BLAH'))
        );
    }

    public function testVoteAbstainedWhenAttributesAreUnsupported()
    {
        $user = $this->getUser();
        $token = $this->getUserToken($user);

        $this->assertEquals(
            VoterInterface::ACCESS_ABSTAIN,
            $this->voter->vote($token,null,array('ROLE_FOO'))
        );
    }

    protected function getUser()
    {
        return m::mock('SGS\Model\User');
    }

    protected function getUserToken($user)
    {
        $token = m::mock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $token->shouldReceive('getUser')->andReturn($user);
        return $token;
    }
}