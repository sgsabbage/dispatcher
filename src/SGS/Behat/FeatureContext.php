<?php
namespace SGS\Behat;

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\MinkExtension\Context\MinkContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use SGS\Model\User;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends MinkContext implements \Behat\Symfony2Extension\Context\KernelAwareInterface
{

    /**
     * @var \Symfony\Component\HttpKernel\KernelInterface $kernel
     */
    private $kernel = null;
    
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }

    /**
     * @param \Symfony\Component\HttpKernel\KernelInterface $kernel
     *
     * @return null
     */
    public function setKernel(\Symfony\Component\HttpKernel\KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given /^an? (dispatcher|requester|engineer) identified by "([^"]*)", "([^"]*)"$/
     */
    public function aUserIdentifiedBy($type, $email, $pass)
    {
        $user = new User();

        $factory = $this->kernel->getContainer()->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        $pass = $encoder->encodePassword($pass,$user->getSalt());

        $user->setEmail($email);
        $user->setPassword($pass);

        switch ($type){
            case "dispatcher":
                $user->setType(User::TYPE_DISPATCHER);
                break;
            case "requester":
                $user->setType(User::TYPE_REQUESTER);
                break;
            case "engineer":
                $user->setType(User::TYPE_ENGINEER);
                break;
        }
    }
}
