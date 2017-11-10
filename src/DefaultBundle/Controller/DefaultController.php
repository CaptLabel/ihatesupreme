<?php

namespace DefaultBundle\Controller;

use DefaultBundle\Entity\Freedom;
use DefaultBundle\Entity\Purchase;
use DefaultBundle\Entity\PurchaseTest;
use DefaultBundle\Form\FreedomType;
use DefaultBundle\Form\PurchaseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $intro = null;
        if(!$request->cookies->has('intro')){
            $repository = $this->getDoctrine()->getRepository('DefaultBundle:Introduction');
            $introductions = $repository->findAll();
            $response = new Response();
            $response->headers->setCookie(new Cookie('intro', '1', strtotime('now + 1 day')));
            $response->send();
            //todo Retirer cette logique du controller
            //todo !!! cassé en PROD !!!!
            if(isset($introductions)){
                $key = array_rand($introductions,1);
                $intro = $introductions[$key];
            }
        }
        return $this->render('DefaultBundle:Default:index.html.twig', array('intro' => $intro));
    }
    public function todayAction()
    {

        $ids = $this->get('today.manager')->getIdPhoto();

        return $this->redirect($this->generateUrl('default_ihateseriephoto', array('id' => $ids[0], 'idp' => $ids[1])));
    }
    public function freedomAction(Request $request)
    {
        $freedom = new Freedom();
        $form = $this->get('form.factory')->create(FreedomType::class, $freedom);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $freedom->setUserIp($request->getClientIp());
            $em->persist($freedom);
            $em->flush();
            return $this->redirect($this->generateUrl('default_ihatefreedom_conf'));
        }
        $edition = true;
        if($request->cookies->has('freedom')){
            $edition = false;
        }
        return $this->render('DefaultBundle:Default:ihatefreedom.html.twig', array(
            'form' => $form->createView(),
            'edition' => $edition
        ));
    }
    public function loveAction()
    {
        $repository = $this->getDoctrine()->getRepository('DefaultBundle:Loveyou');
        $listLoveyou = $repository->findAll();
        return $this->render('DefaultBundle:Default:iloveyou.html.twig', array('listLoveyou' => $listLoveyou));
    }
    public function purchaseAction(Request $request)
    {
        $session = $request->getSession();
        $panier = $session->get('panier');
        $this->get('purchase.manager')->setPanier($panier);
        $purchase = new Purchase();
        if($this->get('kernel')->getEnvironment() === "dev" && $request->get('test') === "1"){
            $purchase = $this->get('test.manager')->testPurchase($purchase);
        }
        $form = $this->createForm(PurchaseType::class, $purchase);
        $purchase_form = $request->request->get('defaultbundle_purchase');
        $purchase_list = $purchase_form['purchase_list'];
        if ($form->handleRequest($request)->isValid() && !empty($purchase_list)) {
            $session->remove('panier');
            $this->get('purchase.manager')->purchaseAction($purchase, $purchase_list, $request->get('amount'));
            return $this->redirectToRoute('default_ihatepurchase_conf');
        }
        return $this->render('DefaultBundle:Default:ihatepurchase.html.twig', array(
            'form' => $form->createView(),
            'listArticle' => $this->get('purchase.manager')->getListArticle(),
            'id_body' => 'body_2'
        ));
    }
}
