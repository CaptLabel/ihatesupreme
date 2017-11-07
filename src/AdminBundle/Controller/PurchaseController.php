<?php

namespace AdminBundle\Controller;

use DefaultBundle\Form\PurchaseUpdateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PurchaseController extends Controller
{
    public function showAction()
    {
        $repository = $this->getDoctrine()->getRepository('DefaultBundle:Purchase');
        $listPurchase = $repository->findBy(array(), array('datePurchase' => 'DESC'));
        return $this->render('AdminBundle:Purchase:admin.purchase.html.twig', array(
            'listPurchase' => $listPurchase
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Purchase');
        $purchase = $repository->find($id);
        $form = $this->get('form.factory')->create(PurchaseUpdateType::class, $purchase);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($purchase);
            $em->flush();
            return $this->redirect($this->generateUrl('admin_purchase'));
        }
        return $this->render('AdminBundle:Form:admin.form.add.html.twig', array(
            'form' => $form->createView(),
            'title' => 'modifier un status.'
        ));
    }
}
