<?php

namespace App\Controller;

use App\Entity\Commented;
use App\Entity\Post;
use App\Entity\User;
use App\Form\CommentType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/showC/{id}", name="showC")
     */
    public function showC($id, Request $request): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find(25451120);
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $cmts = $this->getDoctrine()->getRepository(Commented::class)->findBypostcommented($id);
        $comments=$this->getDoctrine()->getRepository(Commented::class)->findAll();


        $cmt = new Commented();

        $form = $this->createForm(CommentType::class, $cmt);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            $currentDate = new \datetime();

            $cmt->setCreatedat($currentDate);

            $cmt->setUserwhocommented($user);
            $cmt->setPostcommented($post);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cmt);
            $entityManager->flush();
            return $this->redirectToRoute('showC', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        return $this->render('FrontOffice/comment.html.twig', ["formC" => $form->createView(), "comments" => $cmts,"post"=>$post]);
    }
    /**
     * @Route ("/DeleteC/{crt}",name="deleteC")
     */
    public function deleteC($crt)
    {
        $em=$this->getDoctrine()->getManager();
        $cmt = $this->getDoctrine()->getRepository(Commented::class)->find($crt);

        $em->remove($cmt[0]);
        $em->flush();
        return $this->redirectToRoute('showC',['id'=>$crt]);
    }
    /**
     * @Route("/editC/{id}/{crt}", name="editC")
     */
    public function editC(Request $request,$id,$crt): Response
    {
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $cmts = $this->getDoctrine()->getRepository(Commented::class)->findBypostcommented($id);

        $cmt = $this->getDoctrine()->getRepository(Commented::class)->find($crt);

        $formE = $this->createForm(CommentType::class, $cmt);

        $formE->handleRequest($request);
        if ($formE->isSubmitted() && $formE->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('showC',['id'=>$id]);
        }

        return $this->render('FrontOffice/comment.html.twig',array('formC'=>$formE->createView(),'comments'=>$cmts,"post"=>$post));
    }
}
