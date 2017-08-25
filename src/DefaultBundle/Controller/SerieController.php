<?php

namespace DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class SerieController extends Controller
{
    public function seriesAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Serie');
        $repositoryPhoto = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Photo');
        $listSerie = $repository->findAll();
        $array_photo = array();
        foreach($listSerie as $item){
            $photo = $repositoryPhoto->findOneBy(array('serie' => $item->getId()));
            $array_photo[$item->getId()] = $photo;
        }
        return $this->render('DefaultBundle:Serie:ihateseries.html.twig', array('listSerie' => $listSerie, 'array_photo' => $array_photo, 'id_body' => "body_2"));
    }
    public function editoAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Serie');
        $serie = $repository->find($id);
        if(is_null($serie)){
            return $this->redirect($this->generateUrl('default_homepage'));
        }
        return $this->render('DefaultBundle:Serie:ihateedito.html.twig', array('serie' => $serie));
    }
    public function goingAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Serie');
        $serie = $repository->find($id);
        if(is_null($serie)){
            return $this->redirect($this->generateUrl('default_homepage'));
        }
        return $this->render('DefaultBundle:Serie:ihategoing.html.twig', array(
            'serie' => $serie,
        ));
    }
    public function seriephotoAction($id, $idp)
    {
        $photoRep = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Photo');
        $array_photo = $photoRep->findArrayIdPhoto($id);
        if(count($array_photo) == 0){
            return $this->redirect($this->generateUrl('default_homepage'));
        }
        $photo = $photoRep->find($array_photo[$idp]['id']);
        $photoCount = count($array_photo);
        if($photoCount-1 > $idp){
            $nextidx = $idp+1;
            if($idp == 0){
                $previdx = $photoCount-1;
            }else{
                $previdx = $nextidx-2;
            }
        }else{
            $nextidx = 0;
            $previdx = $photoCount-2;
        }
        $session = new Session();
        $panier = $session->get('panier');
        if(!is_array($panier)){
            $panier = array();
        }
        $inPanier = false;
        if (in_array($array_photo[$idp]['id'], $panier)) {
            $inPanier = true;
        }
        return $this->render('DefaultBundle:Serie:ihateseriephoto.html.twig', array(
            'photo' => $photo,
            'nextidx' => $nextidx,
            'previdx' => $previdx,
            'inPanier' => $inPanier,
            'photoCount' => $photoCount
        ));
    }
}
