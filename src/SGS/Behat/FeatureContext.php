<?php
namespace SGS\Behat;

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\MinkExtension\Context\MinkContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\Step;

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
     * @BeforeScenario
     */
    public function cleanDatabase($event)
    {
        $metadatas = $this->kernel->getContainer()->get('doctrine')->getEntityManager()->getMetadataFactory()->getAllMetadata();

        if ( ! empty($metadatas)) {
            $tool = new \Doctrine\ORM\Tools\SchemaTool($this->kernel->getContainer()->get('doctrine')->getEntityManager());
            $tool->dropDatabase();
            $tool->createSchema($metadatas);
        } else {
            throw new Doctrine\DBAL\Schema\SchemaException('No Metadata Classes to process.');
        }
    }

    /**
     * @Given /^an? (multi-role user|admin|dispatcher|requester|agent) identified by "([^"]*)", "([^"]*)"$/
     */
    public function aUserIdentifiedBy($type, $email, $pass)
    {
        $container = $this->kernel->getContainer();
        $user = new User();

        $factory = $container->get('security.encoder_factory');
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
            case "agent":
                $user->setType(User::TYPE_AGENT);
                break;
            case "admin":
                $user->setType(User::TYPE_ADMIN);
                break;
            case "multi-role user":
                $user->setType(255);
                break;
        }

        $em = $container->get('doctrine')->getEntityManager();
        $em->persist($user);
        $em->flush();
    }

    /**
     * @When /^I log in as an? (admin|dispatcher|requester|agent) with "([^"]*)", "([^"]*)"$/
     */
    public function iLogIn($type, $email, $pass)
    {
        $types = array(
            'admin' => 'admin',
            'dispatcher' => 'dispatch',
            'requester' => 'request',
            'agent' => 'agent'
        );

        return array(
            new Step\Given('I am on "'.$types[$type].'"'),
            new Step\When("I fill in \"email\" with \"$email\""),
            new Step\When("I fill in \"password\" with \"$pass\""),
            new Step\When("I press \"Login\"")
        );
    }
}
