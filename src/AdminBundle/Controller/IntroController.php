<?php

namespace AdminBundle\Controller;

use DefaultBundle\Entity\Introduction;
use DefaultBundle\Form\IntroductionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IntroController extends Controller
{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Introduction');
        $listIntro = $repository->findAll();
        return $this->render('AdminBundle:Intro:admin.intro.html.twig', array(
            'listIntro' => $listIntro
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $intro = new Introduction();
        $form = $this->get('form.factory')->create(IntroductionType::class, $intro);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($intro);
            $em->flush();
            return $this->redirect($this->generateUrl('admin_introduction'));
        }
        return $this->render('AdminBundle:Form:admin.form.add.html.twig', array(
            'form' => $form->createView(),
            'title' => 'ajouter une introduction.'
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
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Introduction');
        $intro = $repository->find($id);
        $form = $this->get('form.factory')->create(IntroductionType::class, $intro);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($intro);
            $em->flush();
            return $this->redirect($this->generateUrl('admin_introduction'));
        }
        return $this->render('AdminBundle:Form:admin.form.add.html.twig', array(
            'form' => $form->createView(),
            'title' => 'modifier une introduction.'
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Introduction');
        $intro = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($intro);
        $em->flush();
        return $this->redirect($this->generateUrl('admin_introduction'));
    }
}
