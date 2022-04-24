<?php

namespace App\Controller;

use App\Entity\Annoncement;
use App\Form\AnnoncementType;
use App\Repository\AnnoncementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/annoncement/crud")
 */
class AnnoncementCrudController extends AbstractController
{
    /**
     * @Route("/", name="app_annoncement_crud_index", methods={"GET"})
     */
    public function index(AnnoncementRepository $annoncementRepository): Response
    {
        return $this->render('annoncement_crud/index.html.twig', [
            'annoncements' => $annoncementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_annoncement_crud_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AnnoncementRepository $annoncementRepository): Response
    {
        $annoncement = new Annoncement();
        $form = $this->createForm(AnnoncementType::class, $annoncement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annoncementRepository->add($annoncement);
            return $this->redirectToRoute('app_annoncement_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annoncement_crud/new.html.twig', [
            'annoncement' => $annoncement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idann}", name="app_annoncement_crud_show", methods={"GET"})
     */
    public function show(Annoncement $annoncement): Response
    {
        return $this->render('annoncement_crud/show.html.twig', [
            'annoncement' => $annoncement,
        ]);
    }

    /**
     * @Route("/{idann}/edit", name="app_annoncement_crud_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Annoncement $annoncement, AnnoncementRepository $annoncementRepository): Response
    {
        $form = $this->createForm(AnnoncementType::class, $annoncement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annoncementRepository->add($annoncement);
            return $this->redirectToRoute('app_annoncement_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annoncement_crud/edit.html.twig', [
            'annoncement' => $annoncement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idann}", name="app_annoncement_crud_delete", methods={"POST"})
     */
    public function delete(Request $request, Annoncement $annoncement, AnnoncementRepository $annoncementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annoncement->getIdann(), $request->request->get('_token'))) {
            $annoncementRepository->remove($annoncement);
        }

        return $this->redirectToRoute('app_annoncement_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
