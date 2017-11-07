<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 31/10/2017
 * Time: 08:23
 */

namespace DefaultBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class PanierManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function addItem($id){
        $photo = $this->em->getRepository('DefaultBundle:Photo')->find($id);
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

    public function removeItem($id){
        $photo = $this->em->getRepository('DefaultBundle:Photo')->find($id);
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

    private function isExist(){
        //todo sortir les checks
    }

    private function isInside(){
        //todo sortir les checks
    }

    public function cleanPanier(){
        $session = new Session();
        $session->remove('panier');
        $ret['status'] = "OK";
        $response = new Response(json_encode($ret));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function __construct(EntityManagerInterface $em)
    {

        $this->em = $em;
    }
}