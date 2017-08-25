<?php

namespace AdminBundle\Controller;

use DefaultBundle\Entity\Status;
use DefaultBundle\Form\StatusType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StatusController extends Controller
{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Status');
        $listStatus = $repository->findAll();
        return $this->render('AdminBundle:Status:admin.status.html.twig', array(
            'listStatus' => $listStatus
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $intro = new Status();
        $form = $this->get('form.factory')->create(StatusType::class, $intro);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($intro);
            $em->flush();
            return $this->redirect($this->generateUrl('admin_status'));
        }
        return $this->render('AdminBundle:Form:admin.form.add.html.twig', array(
            'form' => $form->createView(),
            'title' => 'ajouter un status.'
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Status');
        $status = $repository->find($id);
        $form = $this->get('form.factory')->create(StatusType::class, $status);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($status);
            $em->flush();
            return $this->redirect($this->generateUrl('admin_status'));
        }
        return $this->render('AdminBundle:Form:admin.form.add.html.twig', array(
            'form' => $form->createView(),
            'title' => 'modifier un status.'
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Status');
        $status = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($status);
        $em->flush();
        return $this->redirect($this->generateUrl('admin_status'));
    }
}
