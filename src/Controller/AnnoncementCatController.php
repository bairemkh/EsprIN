<?php

namespace App\Controller;

use App\Entity\Annoncement;
use App\Entity\Catannonce;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AnnoncementRepository;

class AnnoncementCatController extends AbstractController
{

    /**
     * @Route("/AddNewAnnounceCat", name="AddNewAnnounceCat", methods={"GET", "POST"})
     */
    public function addAnnounceCat(Request $request): Response
    {
        if ($request->request->count() > 0) {
            $announceCat=new Catannonce();
            $announceCat->setLibcatann($request->get('subject'));

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($announceCat);
            $manager->flush();
            return $this->redirectToRoute('AnnounceCatDashboard',[]);
        }

        return $this->render('BackOffice/AddNewAnnounceCat.html.twig', [
        ]);
    }


    /**
     * @Route("/AnnounceCatDashboard/{id}", name="deleteannouncecat")
     */
    public function delete($id)
    {
        $em=$this->getDoctrine()->getManager();
        $post = $this->getDoctrine()
            ->getRepository(Catannonce::class)
            ->find($id);
       $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('AnnounceCatDashboard');
    }




    /**
     * @Route("/AnnounceCatDashboard",name="AnnounceCatDashboard")
     */
    public function AnnounceCatDashboard():Response{

        $announcementCat = $this->getDoctrine()->getRepository(Catannonce::class)->findAll();

        return $this->render('BackOffice/AnnounceCatDashboard.html.twig',[
            'announcementCat'=>$announcementCat
        ]);
    }
}
