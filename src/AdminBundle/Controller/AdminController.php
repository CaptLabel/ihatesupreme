<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminBundle:Default:admin.index.html.twig');
    }

    public function freedomAction()
    {
        $repository = $this->getDoctrine()->getRepository('DefaultBundle:Freedom');
        $listFreedom = $repository->findBy(array(), array('datePost' => 'DESC'));
        return $this->render('AdminBundle:Default:admin.freedom.html.twig', array(
            'listFreedom' => $listFreedom
        ));
    }
}
