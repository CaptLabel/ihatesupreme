<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:Default:admin.index.html.twig');
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function freedomAction()
    {
        $repository = $this->getDoctrine()->getRepository('DefaultBundle:Freedom');
        $listFreedom = $repository->findAll();
        return $this->render('AdminBundle:Default:admin.freedom.html.twig', array(
            'listFreedom' => $listFreedom
        ));
    }
}
