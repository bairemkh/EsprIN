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
            ->findByExampleField('Active');
        return $this->render('BackOffice/EventsDashboard.html.twig',['events'=>$events]);
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
