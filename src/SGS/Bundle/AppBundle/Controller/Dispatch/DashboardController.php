<?php
namespace SGS\Bundle\AppBundle\Controller\Dispatch;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/dispatch")
 */
class DashboardController
{
    /**
     * @Route("", name="dispatch_dashboard_index")
     */
    public function indexAction()
    {

    }
}