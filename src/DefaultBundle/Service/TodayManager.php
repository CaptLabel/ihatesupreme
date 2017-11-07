<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 31/10/2017
 * Time: 08:12
 */

namespace DefaultBundle\Service;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TodayManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function getIdPhoto(){
        //$repositorySerie = $this->getDoctrine()->getRepository('DefaultBundle:Serie');
        $array_serie = $this->em->getRepository('DefaultBundle:Serie')->findArrayIdSerie();
        if(count($array_serie) == 0){
            return new RedirectResponse('default_homepage');
        }
        shuffle($array_serie);
        $id = $array_serie[0]['id'];
        //$repositoryPhoto = $this->getDoctrine()->getRepository('DefaultBundle:Photo');
        $array_photo = $this->em->getRepository('DefaultBundle:Photo')->findArrayIdPhoto($array_serie[0]['id']);
        $idp = rand(0, count($array_photo)-1);
        return [$id, $idp];
    }

    public function __construct(EntityManagerInterface $em)
    {

        $this->em = $em;
    }
}