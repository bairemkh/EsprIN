<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            ->findAll();
        return $this->render('BackOffice/OfferDashboard.html.twig',['offres'=>$offres]);
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
     * @Route("/navbar-v2-offres", name="navbar-v2-offres")
     */
    public function getListOffres():Response
    {
        $offres = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->findAll();
        return $this->render('FrontOffice/navbar-v2-offres.html.twig',['offres'=>$offres]);
    }

    // delete front
    /**
     * @Route ("/navbar-v2-offres/{id}",name="deleteoffresfront")
     */
    public function deleteoffersfront($id)
    {
        $em=$this->getDoctrine()->getManager();
        $offer = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->find($id);
        $offer->setState("Deleted");
        $em->flush();
        return $this->redirectToRoute('navbar-v2-offres');
    }

    /**
     * @Route ("/OffertDashboard/{id}",name="deleteoffer")
     */
    public function delete($id)
    {
        $em=$this->getDoctrine()->getManager();
        $offer = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->find($id);
        $offer->setState("Desactive");
        $em->flush();
        return $this->redirectToRoute('OfferDashboard');
    }

    /**
     * @Route ("/Offertdelete/{id}",name="deleteofferfront")
     */
    public function deletefront($id)
    {
        $em=$this->getDoctrine()->getManager();
        $offer = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->find($id);
        $offer->setState("Desactive");
        $em->flush();
        return $this->redirectToRoute('navbar-v2-offres');
    }

    /**
     * @Route("/addoffer", name="addoffer",methods={"GET", "POST"})
     */
    public function addoffre(Request $request): Response
    {
        dump($request);
        $offer = new Offre();
        $user=$this->getDoctrine()->getRepository(User::class)->find(10020855);
        $offer->setTitleoffer($request->get('title'));
        $offer->setDescoffer($request->get('content'));
        $offer->setCatoffre($request->get('category'));
        $offer->setOfferprovider($user);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($offer);
        $manager->flush();

        return $this->redirectToRoute('navbar-v2-offres');
    }
}
