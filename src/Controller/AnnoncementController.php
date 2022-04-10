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
            ->findAll();
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
}
