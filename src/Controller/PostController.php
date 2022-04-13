<?php

namespace App\Controller;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route ("/PostDashboard",name="PostDashboard")
     */
    public function getPosts():Response
    {
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findAll();
        return $this->render('BackOffice/PostDashboard.html.twig',['posts'=>$posts]);
    }
    /**
     * @Route ("/PostDashboard/{id}",name="deletepost")
     */
    public function delete($id)
    {
        $em=$this->getDoctrine()->getManager();
        $post = $this->getDoctrine()
                    ->getRepository(Post::class)
                    ->find($id);
        $post->setState("Desactive");
        $em->flush();
        return $this->redirectToRoute('PostDashboard');
    }
    /**
     * @Route("/php bin\console make:entity --regenerate", name="app_post_conroller")
     */
    public function index(): Response
    {
        return $this->render('BackOffice/index.html.twig', [
            'controller_name' => 'PostConrollerController',
        ]);
    }
}
