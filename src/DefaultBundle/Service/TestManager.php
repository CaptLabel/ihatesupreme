<?php

namespace DefaultBundle\Service;


use DefaultBundle\Entity\Purchase;

class TestManager
{
    public function testPurchase(Purchase $purchase){
        $purchase->setAdress('24 rue de la gare');
        $purchase->setCity('uneville');
        $purchase->setEmail('test@test.com');
        $purchase->setFirstname('prenom');
        $purchase->setLastname('nomdefamille');
        $purchase->setZipCode('75009');
        $purchase->setNumber('0600000000');
        return $purchase;
    }
}