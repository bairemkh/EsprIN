<?php

namespace App\Controller;

use App\Entity\Commented;
use App\Entity\Post;
use App\Entity\User;
use App\Form\CommentedType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commented")
 */
class CommentedController extends AbstractController
{
    /**
     * @Route("/", name="app_commented_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $commenteds = $entityManager
            ->getRepository(Commented::class)
            ->findAll();

        return $this->render('commented/index.html.twig', [
            'commenteds' => $commenteds,
        ]);
    }

    /**
     * @Route("/new", name="app_commented_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commented = new Commented();
        $form = $this->createForm(CommentedType::class, $commented);

        $form->handleRequest($request);
        $user = $this->getDoctrine()->getRepository(User::class)->find(25451120);
        $post= $this->getDoctrine()->getRepository(Post::class)->find(10);
        $currentDate = new \datetime();
        if ($form->isSubmitted() && $form->isValid()) {
            $commented->setCreatedat($currentDate);
            $commented->setUserwhocommented($user);
            $commented->setPostcommented($post);
            $entityManager->persist($commented);
            $entityManager->flush();

            return $this->redirectToRoute('app_commented_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commented/new.html.twig', [
            'commented' => $commented,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{createdat}", name="app_commented_show", methods={"GET"})
     */
    public function show(Commented $commented): Response
    {
        return $this->render('commented/show.html.twig', [
            'commented' => $commented,
        ]);
    }

    /**
     * @Route("/{createdat}/edit", name="app_commented_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Commented $commented, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentedType::class, $commented);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commented_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commented/edit.html.twig', [
            'commented' => $commented,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{createdat}", name="app_commented_delete", methods={"POST"})
     */
    public function delete(Request $request, Commented $commented, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commented->getIdcomment(), $request->request->get('_token'))) {
            $entityManager->remove($commented);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commented_index', [], Response::HTTP_SEE_OTHER);
    }
}
