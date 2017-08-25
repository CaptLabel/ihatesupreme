<?php

namespace AdminBundle\Controller;

use DefaultBundle\Entity\Serie;
use DefaultBundle\Form\SerieType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SerieController extends Controller
{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Serie');
        $listSerie = $repository->findAll();
        return $this->render('AdminBundle:Serie:admin.serie.html.twig', array(
            'listSerie' => $listSerie
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $serie = new Serie();
        $form = $this->get('form.factory')->create(SerieType::class, $serie);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($serie);
            $em->flush();
            return $this->redirect($this->generateUrl('admin_serie'));
        }
        return $this->render('AdminBundle:Serie:admin.serie.add.html.twig', array(
            'form' => $form->createView(),
            'action' => 'ajouter'
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
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Serie');
        $serie = $repository->find($id);
        $form = $this->get('form.factory')->create(SerieType::class, $serie);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($serie);
            $em->flush();
            return $this->redirect($this->generateUrl('admin_serie'));
        }
        return $this->render('AdminBundle:Serie:admin.serie.add.html.twig', array(
            'form' => $form->createView(),
            'action' => 'modifier'
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Serie');
        $serie = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($serie);
        $em->flush();
        return $this->redirect($this->generateUrl('admin_serie'));
    }
}
