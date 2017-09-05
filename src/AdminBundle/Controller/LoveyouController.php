<?php

namespace AdminBundle\Controller;

use DefaultBundle\Entity\Loveyou;
use DefaultBundle\Form\LoveyouType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LoveyouController extends Controller
{
    public function showAction()
    {
        $test = "DefaultBundle:Loveyou";
        $repository = $this->getDoctrine()->getRepository($test);
        $listLove = $repository->findAll();
        return $this->render('AdminBundle:Loveyou:admin.loveyou.html.twig', array(
            'listLove' => $listLove
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $intro = new Loveyou();
        $form = $this->get('form.factory')->create(LoveyouType::class, $intro);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($intro);
            $em->flush();
            return $this->redirect($this->generateUrl('admin_loveyou'));
        }
        return $this->render('AdminBundle:Form:admin.form.add.html.twig', array(
            'form' => $form->createView(),
            'title' => 'ajouter un lien.'
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Loveyou');
        $intro = $repository->find($id);
        $form = $this->get('form.factory')->create(LoveyouType::class, $intro);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($intro);
            $em->flush();
            return $this->redirect($this->generateUrl('admin_loveyou'));
        }
        return $this->render('AdminBundle:Form:admin.form.add.html.twig', array(
            'form' => $form->createView(),
            'title' => 'modifier un lien.'
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Loveyou');
        $intro = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($intro);
        $em->flush();
        return $this->redirect($this->generateUrl('admin_loveyou'));
    }

}
