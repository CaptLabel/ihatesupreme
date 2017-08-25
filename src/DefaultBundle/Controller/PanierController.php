<?php

namespace DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class PanierController extends Controller
{
    public function cleanAction()
    {
        $session = new Session();
        $session->remove('panier');
        $ret['status'] = "OK";
        $response = new Response(json_encode($ret));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    public function addAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Photo');
        $photo = $repository->find($id);
        if(empty($photo)){
            $ret['status'] = "KO";
            $ret['message'] = "Cet article n'existe pas";
            $response = new Response(json_encode($ret));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        $session = new Session();
        $panier = $session->get('panier');
        if(!is_array($panier)){
            $panier = array();
        }
        if (in_array($id, $panier)) {
            $ret['status'] = "KO";
            $ret['message'] = "Cet article est deja dans le panier";
            $response = new Response(json_encode($ret));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        if(!is_array($panier)){
            $panier = array();
        }
        array_push($panier, $id);
        $session->set('panier', $panier);
        $ret['panier'] = $panier;
        $ret['status'] = "OK";
        $response = new Response(json_encode($ret));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    public function removeAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Photo');
        $photo = $repository->find($id);
        if(empty($photo)){
            $ret['status'] = "KO";
            $ret['message'] = "Cet article n'existe pas";
            $response = new Response(json_encode($ret));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        $session = new Session();
        $panier = $session->get('panier');
        if(!in_array($id, $panier)){
            $ret['status'] = "KO";
            $ret['message'] = "Cet article n'est pas dans le panier";
            $response = new Response(json_encode($ret));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        $key = array_search($id, $panier);
        unset($panier[$key]);
        $session->set('panier', $panier);
        $ret['panier'] = $panier;
        $ret['status'] = "OK";
        $response = new Response(json_encode($ret));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
