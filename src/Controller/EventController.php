<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route ("/EventsDashboard",name="EventsDashboard")
     */
    public function getEvents():Response
    {
        $events = $this->getDoctrine()
            ->getRepository(Event::class)
            ->findAll();
        return $this->render('BackOffice/EventsDashboard.html.twig',['events'=>$events]);
    }

    /**
     * @Route("/navbar-v2-events", name="navbar-v2-event")
     */
    public function getlistevents():Response
    {
        $events = $this->getDoctrine()
            ->getRepository(Event::class)
            ->findAll();
        return $this->render('FrontOffice/navbar-v2-events.html.twig',['events'=>$events]);
    }

    /**
     * @Route ("/EventsDashboard/{id}",name="deleteevent")
     */
    public function deleteevent($id)
    {
        $em=$this->getDoctrine()->getManager();
        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);
        $event->setState("Deleted");
        $em->flush();
        return $this->redirectToRoute('EventsDashboard');
    }
    /**
     * @Route("/event", name="app_event")
     */
    public function index(): Response
    {
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }
}
