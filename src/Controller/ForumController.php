<?php

namespace App\Controller;


use App\Entity\Forum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    /**
     * @Route ("/ForumDashboard",name="ForumDashboard")
     */
    public function getForums(): Response
    {
        $forums= $this->getDoctrine()
            ->getRepository(Forum::class)
            ->findByStateField('Active');
        return $this->render('BackOffice/ForumDashboard.html.twig',['forums'=>$forums]);
    }

    /**
     * @Route("/navbar-v2-events", name="navbar-v2-events")
     */
    public function getlistforums(): Response
    {
        $forums= $this->getDoctrine()
            ->getRepository(Forum::class)
            ->findAll();
        return $this->render('FrontOffice/navbar-v2-forums.html.twig',['forums'=>$forums]);
    }

    /**
     * @Route("/forum", name="app_forum")
     */
    public function index(): Response
    {
        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }
    /**
     * @Route ("/ForumDashboard/{id}",name="deleteforum")
     */
    public function delete($id)
    {
        $em=$this->getDoctrine()->getManager();
        $forum = $this->getDoctrine()
            ->getRepository(Forum::class)
            ->find($id);
        $forum->setState("Deleted");
        $em->flush();
        return $this->redirectToRoute('ForumDashboard');
    }
}
