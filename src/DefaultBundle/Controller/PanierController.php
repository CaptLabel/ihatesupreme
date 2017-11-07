<?php

namespace DefaultBundle\Controller;

use DefaultBundle\Service\PanierManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PanierController extends Controller
{
    public function cleanAction()
    {
        $this->get('panier.manager')->cleanPanier();
    }
    public function addAction($id)
    {
        return $this->get('panier.manager')->addItem($id);
    }
    public function removeAction($id)
    {
        return $this->get('panier.manager')->removeItem($id);
    }
}
