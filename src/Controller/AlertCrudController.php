<?php

namespace App\Controller;

use App\Entity\Alert;
use App\Form\AlertType;
use App\Repository\AlertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/alert/crud")
 */
class AlertCrudController extends AbstractController
{
    /**
     * @Route("/", name="app_alert_crud_index", methods={"GET"})
     */
    public function index(AlertRepository $alertRepository): Response
    {
        return $this->render('alert_crud/index.html.twig', [
            'alerts' => $alertRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_alert_crud_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AlertRepository $alertRepository): Response
    {
        $alert = new Alert();
        $form = $this->createForm(AlertType::class, $alert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $alertRepository->add($alert);
            return $this->redirectToRoute('app_alert_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('alert_crud/new.html.twig', [
            'alert' => $alert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idalert}", name="app_alert_crud_show", methods={"GET"})
     */
    public function show(Alert $alert): Response
    {
        return $this->render('alert_crud/show.html.twig', [
            'alert' => $alert,
        ]);
    }

    /**
     * @Route("/{idalert}/edit", name="app_alert_crud_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Alert $alert, AlertRepository $alertRepository): Response
    {
        $form = $this->createForm(AlertType::class, $alert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $alertRepository->add($alert);
            return $this->redirectToRoute('app_alert_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('alert_crud/edit.html.twig', [
            'alert' => $alert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idalert}", name="app_alert_crud_delete", methods={"POST"})
     */
    public function delete(Request $request, Alert $alert, AlertRepository $alertRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$alert->getIdalert(), $request->request->get('_token'))) {
            $alertRepository->remove($alert);
        }

        return $this->redirectToRoute('app_alert_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
