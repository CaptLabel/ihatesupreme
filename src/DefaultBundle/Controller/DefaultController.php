<?php

namespace DefaultBundle\Controller;

use DefaultBundle\Entity\Freedom;
use DefaultBundle\Entity\Purchase;
use DefaultBundle\Form\FreedomType;
use DefaultBundle\Form\PurchaseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

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
            $key = array_rand($introductions,1);
            $intro = $introductions[$key];
        }
        return $this->render('DefaultBundle:Default:index.html.twig', array('intro' => $intro));
    }
    public function todayAction()
    {
        $repositorySerie = $this->getDoctrine()->getRepository('DefaultBundle:Serie');
        $array_serie = $repositorySerie->findArrayIdSerie();
        if(count($array_serie) == 0){
            return $this->redirect($this->generateUrl('default_homepage'));
        }
        shuffle($array_serie);
        $id = $array_serie[0]['id'];
        $repositoryPhoto = $this->getDoctrine()->getRepository('DefaultBundle:Photo');
        $array_photo = $repositoryPhoto->findArrayIdPhoto($array_serie[0]['id']);
        $idp = rand(0, count($array_photo)-1);
        return $this->redirect($this->generateUrl('default_ihateseriephoto', array('id' => $id, 'idp' => $idp)));
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
        $purchase = new Purchase();
        $form = $this->createForm(PurchaseType::class, $purchase);
        $purchase_form = $request->request->get('defaultbundle_purchase');
        $purchase_list = $purchase_form['purchase_list'];

        if ($form->handleRequest($request)->isValid() && !empty($purchase_list)) {
            $purchase_list = explode(',', $purchase_list);
            $em = $this->getDoctrine()->getManager();
            $repositoryPhoto = $this->getDoctrine()->getRepository('DefaultBundle:Photo');
            $buyList = array();
            foreach($purchase_list as $item){
                $photo = $repositoryPhoto->findInfoBuyList($item);
                if(!empty($photo)){
                    array_push($buyList, $photo);
                }
            }
            if(count($buyList) > 0){
                $purchase->setBuyList(json_encode($buyList));
            }

            $amount = $request->get('amount');
            //$purchase->setAmount($amount);

            // Message client
            $message = \Swift_Message::newInstance()
                ->setSubject('Confirmation de votre commande')
                ->setFrom($this->container->getParameter('email_from'))
                ->setTo($purchase->getEmail())
                ->setBody(
                    $this->renderView(
                        '@Default/Mail/mail.confirmation.purchase.html.twig',
                        array('purchase' => $purchase, 'buyList' => $buyList, 'amount' => $amount)
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);

            // Message admin
            $message = \Swift_Message::newInstance()
                ->setSubject('Une nouvelle commande i hate supreme')
                ->setFrom($this->container->getParameter('email_from'))
                ->setTo($this->container->getParameter('email_admin'))
                ->setBody(
                    $this->renderView(
                        '@Admin/Mail/mail.admin.confirmation.purchase.html.twig',
                        array('purchase' => $purchase, 'buyList' => $buyList, 'amount' => $amount)
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);

            $repositoryStatus = $this->getDoctrine()->getRepository('DefaultBundle:Status');
            $status = $repositoryStatus->find(1);
            $purchase->setStatus($status);
            $session->remove('panier');
            $em->persist($purchase);
            $em->flush();
            return $this->redirect($this->generateUrl('default_ihatepurchase_conf'));

        }
        $listArticle = array();
        $id_body = "body";
        if(count($panier) > 0){
            $repositoryPhoto = $this->getDoctrine()->getRepository('DefaultBundle:Photo');
            foreach($panier as $item){
                $photo = $repositoryPhoto->find($item);
                array_push($listArticle, $photo);
            }
            $id_body = "body_2";
        }
        return $this->render('DefaultBundle:Default:ihatepurchase.html.twig', array(
            'form' => $form->createView(),
            'listArticle' => $listArticle,
            'id_body' => $id_body
        ));
    }
}
