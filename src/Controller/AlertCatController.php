<?php

namespace App\Controller;

use App\Entity\Alert;
use App\Entity\Annoncement;
use App\Entity\Catalert;
use App\Entity\Catannonce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlertCatController extends AbstractController
{

    /**
     * @Route("/AlertCatDashboard/{id}", name="deletealertcat")
     */
    public function delete($id)
    {

        $em=$this->getDoctrine()->getManager();
        $post = $this->getDoctrine()
            ->getRepository(Catalert::class)
            ->find($id);
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('AlertCatDashboard');
    }




    /**
     * @Route("/AlertCatDashboard",name="AlertCatDashboard")
     */
    public function alertCatDashboard():Response{

        $alertsCat = $this->getDoctrine()->getRepository(Catalert::class)->findAll();

        return $this->render('BackOffice/AlertCatDashboard.html.twig',[
            'alertsCat'=>$alertsCat
        ]);
    }

}
