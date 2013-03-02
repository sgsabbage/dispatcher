<?php
namespace SGS\Bundle\AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\DependencyInjection\ContainerAware;

class LoginController extends ContainerAware
{
    /**
     * @Route("/login")
     * @Template()
     */
    public function loginAction()
    {
        $request = $this->container->get('request');
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
                // last username entered by the user
                'last_email' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
        );
    }

    /**
     * @Route("/denied")
     * @Template()
     */
    public function deniedAction()
    {
        return array();
    }
}