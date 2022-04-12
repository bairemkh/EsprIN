<?php

namespace App\Controller;

use App\Entity\Annoncement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnoncementController extends AbstractController
{
    /**
     * @Route ("/AnnounceDashboard",name="AnnounceDashboardd")
     */
    public function getAnnounces():Response{
        $announces= $this->getDoctrine()
            ->getRepository(Annoncement::class)
            ->findByStateField('Active');
        return $this->render('BackOffice/AnnounceDashboard.html.twig',['announces'=>$announces]);
    }
    /**
     * @Route("/annoncement", name="app_annoncement")
     */
    public function index(): Response
    {
        return $this->render('annoncement/index.html.twig', [
            'controller_name' => 'AnnoncementController',
        ]);
    }

    /**
     * @Route("/AnnounceDashboard/{id}", name="deleteannounce")
     */
    public function delete($id)
    {
        $em=$this->getDoctrine()->getManager();
        $post = $this->getDoctrine()
            ->getRepository(Annoncement::class)
            ->find($id);
        $post->setState("Deleted");
        $em->flush();
        return $this->redirectToRoute('AnnounceDashboard');
    }
}
