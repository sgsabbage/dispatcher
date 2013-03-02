<?php
namespace SGS\Bundle\AppBundle\Controller\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\DependencyInjection\ContainerAware;
use SGS\Model\Job;
use SGS\Bundle\AppBundle\Form\Request\Job\NewType;

/**
 * @Route("/job")
 */
class JobController extends ContainerAware
{
    /**
     * @Route("/new", name="request_job_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Job();
        $form = $this->container->get('form.factory')
            ->create(new NewType(),$entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/new", name="request_job_create")
     * @Method("POST")
     * @Template("SGSAppBundle:Request\Job:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Job();
        $form = $this->container->get('form.factory')
            ->create(new NewType(), $entity);

        $form->bind($request);

        if ($form->isValid()) {
            $user= $this->container->get('security.context')
                        ->getToken()->getUser();
            $entity->setRequester($user);
            $em = $this->container->get('doctrine')
                ->getEntityManager();
            $em->persist($entity);
            $em->flush();

            $route = $this->container->get('router')
                ->generate('request_job_show', array('id' => $entity->getId()));

            return new RedirectResponse($route);
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * @Route("/{id}", name="request_job_show")
     * @Template()
     */
    public function showAction(Job $entity)
    {

        $user= $this->container->get('security.context')
                        ->getToken()->getUser();

        if($user != $entity->getRequester()) {
            $route = $this->container->get('router')
                ->generate('request_dashboard');
            $this->container->get('session')->getFlashBag()
                ->add('error', 'request.invalid.job');

            return new RedirectResponse($route);
        }
        return array(
            'entity' => $entity
        );
    }
}