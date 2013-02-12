<?php
namespace SGS\Bundle\AppBundle\Controller\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * @Route("/request")
 */
class DashboardController extends ContainerAware
{
    /**
     * @Route("")
     * @Template()
     */
    public function indexAction()
    {
        $user = $this->container->get('security.context')
            ->getToken()->getUser();
        $jobs = $this->container->get('doctrine')
            ->getEntityManager()->getRepository('Model:Job')
            ->findByRequester($user);

        return array('jobs' => $jobs);
    }
}