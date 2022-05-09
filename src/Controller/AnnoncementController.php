<?php

namespace App\Controller;

use App\Entity\Annoncement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AnnoncementRepository;

class AnnoncementController extends AbstractController
{


    /**
     * @Route("/announcementDashboard",name="announcementDashboard")
     */
    public function GetAnnoucement():Response{
        $announcement=$this->getDoctrine()
            ->getRepository(Annoncement::class)
            ->findAll();
        return $this->render('BackOffice/AnnounceDashboard.html.twig',[
           'announcement'=>$announcement
        ]);
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

        /**
         * @Route("/addAnnoncement", name="add_new_annoncement", methods={"GET", "POST"})
         */
        public function addAnnounce(Request $request): Response
        {
            dump($request);
            if ($request->request->count() > 0) {
                $announce=new Annoncement();
                $announce->setSubject($request->get('subject'));
                $user=$this->getDoctrine()->getRepository(User::class)->find(10020855);
                echo $user->getLastname()." ".$user->getFirstname();
                $announce->setIdsender($user);
                $announce->setCreatedat(new \DateTime('@' . strtotime('now')));
                $announce->setContent($request->get('content'));
                $announce->setDestination($request->get('destination'));//libCatAnn
                $catAnn=$this->getDoctrine()->getRepository(Catannonce::class)->findOneBy(['libcatann'=>$request->get('Category')]);
                $announce->setCatann($catAnn->getIdcatann());
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($announce);
                $manager->flush();
                return $this->redirectToRoute('AnnounceDashboard',[]);
            }

            return $this->render('BackOffice/AddNewAnnounce.html.twig', [
            ]);
        }

    /* *********** FRONT *********** */

    // affichage front

    /* *********** FRONT *********** */

    // affichage front
    /**
     * @Route("/announceFront", name="announceFront")
     */
    public function getlistann():Response
    {
        $ann = $this->getDoctrine()
            ->getRepository(Annoncement::class)
            ->findByStateField('Active');
        return $this->render('FrontOffice/announceFront.html.twig',['ann'=>$ann]);
    }


}
