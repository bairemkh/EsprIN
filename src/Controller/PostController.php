<?php

namespace App\Controller;
use App\Entity\Commented;
use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route ("/test",name="test")
     */
    public function test():Response
    {
        return $this->render('FrontOffice/comment.html.twig');
    }

    /**
     * @Route ("/showP",name="showP")
     */
    public function showP(Request $request):Response
    {

        $posts = $this->getDoctrine()->getRepository(Post::class)->findByState("'Active'");

        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);


        if ($form->isSubmitted()&& $form->isValid()) {

            $user = $this->getDoctrine()->getRepository(User::class)->find(25451120);
            $currentDate = new \datetime();
            $uploadedFile = $form['mediaURL']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '\public\upload\post';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename);
                $post->setMediaurl($newFilename);
            }
            $post->setCreatedat($currentDate);
            $post->setIdower($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('showP', [], Response::HTTP_SEE_OTHER);


        }



        return $this->render('FrontOffice/post.html.twig',["form" => $form->createView(),'posts'=>$posts]);
    }



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
     * @Route ("/Post/{id}",name="deleteP")
     */
    public function deleteP($id)
    {
        $em=$this->getDoctrine()->getManager();
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $post->setState("Desactive");
        $em->flush();
        return $this->redirectToRoute('showP');
    }
    /**
     * @Route("/editP/{id}", name="editP")
     */
    public function editP(Request $request,$id): Response
    { $posts = $this->getDoctrine()->getRepository(Post::class)->findByState("'Active'");
        $postE = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $formE = $this->createForm(PostType::class, $postE);

        $formE->handleRequest($request);
        if ($formE->isSubmitted() && $formE->isValid() ) {
            $uploadedFile = $formE['mediaURL']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '\public\upload\post';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename);
                $postE->setMediaurl($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('showP');
        }

        return $this->render('FrontOffice/post.html.twig',array('form'=>$formE->createView(),"posts"=>$posts));
    }


}
