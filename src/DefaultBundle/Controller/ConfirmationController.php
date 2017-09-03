<?php

namespace DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class ConfirmationController extends Controller
{
    public function freedomAction()
    {
        $response = new Response();
        $response->headers->setCookie(new Cookie('freedom', '1', strtotime('now + 1 day')));
        $response->send();
        return $this->render('DefaultBundle:Confirmation:ihatefreedom_conf.html.twig');
    }
    public function purchaseAction()
    {
        return $this->render('DefaultBundle:Confirmation:ihatepurchase_conf.html.twig');
    }
}
