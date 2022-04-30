<?php

namespace App\Controller;

use App\Entity\Offre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffreController extends AbstractController
{
    /**
     * @Route ("/OfferDashboard",name="OfferDashboard")
     */
    public function getOffres():Response
    {
        $offres = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->findByStateField('Active');
        return $this->render('BackOffice/OfferDashboard.html.twig',['offres'=>$offres]);
    }

    /**
     * @Route ("/navbar-v2-offres",name="navbar-v2-offres")
     */
    public function getOffresMenu():Response
    {
        $offres = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->findAll();
        return $this->render('FrontOffice/navbar-v2-offres.html.twig',['offres'=>$offres]);
    }
    /**
     * @Route("/offre", name="app_offre")
     */
    public function index(): Response
    {
        return $this->render('offre/index.html.twig', [
            'controller_name' => 'OffreController',
        ]);
    }

    /**
     * @Route ("/OfferDashboard/{id}",name="deleteoffer")
     */
    public function delete($id)
    {
        $em=$this->getDoctrine()->getManager();
        $offer = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->find($id);
        $offer->setState("Deleted");
        $em->flush();
        return $this->redirectToRoute('OfferDashboard');
    }
}
