<?php

namespace DefaultBundle\Service;


use DefaultBundle\Entity\Purchase;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PurchaseManager
{
    /**
     * @var ContainerInterface
     */
    private $mailer;
    /**
     * @var EntityManager
     */
    private $em;

    private $panier;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    private $mail_from;

    private $mail_admin;

    /**
     * @return mixed
     */
    public function getPanier()
    {
        return $this->panier;
    }

    /**
     * @param mixed $panier
     */
    public function setPanier($panier)
    {
        $this->panier = $panier;
    }

    public function purchaseAction(Purchase $purchase, $purchase_list){

        $purchase_list = explode(',', $purchase_list);

        $repositoryPhoto = $this->em->getRepository('DefaultBundle:Photo');
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


        //TODO VIRER CA.... SET EN BASE AUTO
//        $amount = $request->get('amount');
        $amount = 100;
        $purchase->setAmount($amount);

        $this->sendMailPurchaseClient($purchase, $buyList, $amount);
        $this->sendMailPurchaseAdmin($purchase, $buyList, $amount);

        $repositoryStatus = $this->em->getRepository('DefaultBundle:Status');
        $status = $repositoryStatus->find(1);
        $purchase->setStatus($status);

        $this->em->persist($purchase);
        $this->em->flush();
    }

    /**
     * @param $purchase Purchase
     * @param $buyList
     * @param $amount
     */
    private function sendMailPurchaseClient($purchase, $buyList, $amount){
        $message = \Swift_Message::newInstance()
            ->setSubject('Confirmation de votre commande')
            ->setFrom($this->mail_from)
            ->setTo($purchase->getEmail())
            ->setBody(
                $this->twig->render(
                    '@Default/Mail/mail.confirmation.purchase.html.twig',
                    array('purchase' => $purchase, 'buyList' => $buyList, 'amount' => $amount)
                ),
                'text/html'
            );
        //$this->mailer->send($message);
        $this->mailer->send($message);
    }

    private function sendMailPurchaseAdmin($purchase, $buyList, $amount){
        $message = \Swift_Message::newInstance()
            ->setSubject('Une nouvelle commande i hate supreme')
            ->setFrom($this->mail_from)
            ->setTo($this->mail_admin)
            ->setBody(
                $this->twig->render(
                    '@Admin/Mail/mail.admin.confirmation.purchase.html.twig',
                    array('purchase' => $purchase, 'buyList' => $buyList, 'amount' => $amount)
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }

    public function getListArticle(){
        $listArticle = array();
        if(count($this->getPanier()) > 0){
            $repositoryPhoto = $this->em->getRepository('DefaultBundle:Photo');
            foreach($this->getPanier() as $item){
                $photo = $repositoryPhoto->find($item);
                array_push($listArticle, $photo);
            }
        }
        return $listArticle;
    }

    public function __construct(\Swift_Mailer $mailer, EntityManager $em, \Twig_Environment $twig, $mail_from, $mail_admin){
        $this->mailer = $mailer;
        $this->em = $em;
        $this->twig = $twig;
        $this->mail_from = $mail_from;
        $this->mail_admin = $mail_admin;
    }
}