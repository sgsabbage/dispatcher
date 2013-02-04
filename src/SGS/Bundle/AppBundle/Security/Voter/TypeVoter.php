<?php
namespace SGS\Bundle\AppBundle\Security\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TypeVoter implements VoterInterface
{
    public function supportsAttribute($attribute)
    {
        return 0 === strpos($attribute, 'TYPE_');
    }

    public function supportsClass($class)
    {
        return true;
    }

    function vote(TokenInterface $token, $object, array $attributes)
    {
        $result = VoterInterface::ACCESS_ABSTAIN;

        $user = $token->getUser();

        foreach($attributes as $attribute) {
            if(!$this->supportsAttribute($attribute)) {
                continue;
            }

            $result = VoterInterface::ACCESS_DENIED;

            if(!defined('\SGS\Model\User::'.$attribute)) {
                break;
            }

            if($user->hasType(constant('\SGS\Model\User::'.$attribute))){
                $result = VoterInterface::ACCESS_GRANTED;
            }
        }

        return $result;
    }
}