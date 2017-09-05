<?php

namespace AdminBundle\Controller;

use DefaultBundle\Entity\Photo;
use DefaultBundle\Form\PhotoType;
use AdminBundle\Service\KeyImgGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PhotoController extends Controller
{
    public function showAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Photo');
        $listPhoto = $repository->findAll();

        return $this->render('AdminBundle:Photo:admin.photo.html.twig', array(
            'listPhoto' => $listPhoto
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $photo = new Photo();
        $form = $this->get('form.factory')->create(PhotoType::class, $photo);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $keyimgene = $this->get('admin.keyimggenerator');
            $name = $photo->getName();
            $hash = $keyimgene->getKeyImg($name);
            $photo->setKeyImg($hash);
            $em->persist($photo);
            $em->flush();
            return $this->redirect($this->generateUrl('admin_photo'));
        }
        return $this->render('AdminBundle:Form:admin.form.add.html.twig', array(
            'form' => $form->createView(),
            'title' => 'ajouter une photo.'
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Photo');
        $photo = $repository->find($id);
        $form = $this->get('form.factory')->create(PhotoType::class, $photo);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();
            return $this->redirect($this->generateUrl('admin_photo'));
        }
        return $this->render('AdminBundle:Photo:admin.photo.update.html.twig', array(
            'form' => $form->createView(),
            'photo' => $photo
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('DefaultBundle:Photo');
        $photo = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($photo);
        $em->flush();
        return $this->redirect($this->generateUrl('admin_photo'));
    }
}
