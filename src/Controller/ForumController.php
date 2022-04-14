<?php

namespace App\Controller;


use App\Entity\Forum;
use App\Entity\Responded;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            ->findAll();
        return $this->render('BackOffice/ForumDashboard.html.twig',['forums'=>$forums]);
    }

    /**
     * @Route("/navbar-v2-forums", name="navbar-v2-forum")
     */
    public function getlistforums(): Response
    {
        $forums= $this->getDoctrine()
            ->getRepository(Forum::class)
            ->findAll();
        $responded= $this->getDoctrine()
            ->getRepository(Responded::class)
            ->findAll();
        return $this->render('FrontOffice/navbar-v2-forums.html.twig',['forums'=>$forums,'responses'=>$responded]);
    }

    /**
     * @Route("/addresponse/{idforum}", name="createresponse",methods={"GET", "POST"})
     */
    public function addresponse(Request $request,$idforum): Response
    {
        dump($request);
        $response = new Responded();
        $forum=$this->getDoctrine()->getRepository(Forum::class)->find($idforum);
        $user=$this->getDoctrine()->getRepository(User::class)->find(10020855);
        $response->setContent($request->get('responsecontent'));
        $response->setIdforum($forum);
        $response->setCinuser($user);
        $response->setCreatedat(new \DateTime('@' . strtotime('now')));
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($response);
        $manager->flush();

        return $this->redirectToRoute('navbar-v2-forum');
    }
    /**
     * @Route("/addforum", name="addforum",methods={"GET", "POST"})
     */
    public function addforum(Request $request): Response
    {
        dump($request);
        $forum = new Forum();
        $user=$this->getDoctrine()->getRepository(User::class)->find(10020855);
        $forum->setTitle($request->get('title'));
        $forum->setContent($request->get('content'));
        $forum->setCategorieforum($request->get('tag'));
        $forum->setIdowner($user);
        $forum->setNbrlikesforum(0);
        $forum->setDatecreation(new \DateTime('@' . strtotime('now')));
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($forum);
        $manager->flush();

        return $this->redirectToRoute('navbar-v2-forum');
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
}
