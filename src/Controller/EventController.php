<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class EventController extends AbstractController
{

    /**
     * @Route("/event", name="app_event")
     */
    public function index(): Response
    {
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }
    /* ******************* EVENT ******************* */
            /* *********** BACK *********** */

    //affichage back
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

    // delete back
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



           /* *********** FRONT *********** */

    // affichage front
    /**
     * @Route("/navbar-v2-events", name="navbar-v2-event")
     */
    public function getlistevents():Response
    {
        $events = $this->getDoctrine()
            ->getRepository(Event::class)
            ->findByExampleField('Active');
        return $this->render('FrontOffice/navbar-v2-events.html.twig',['events'=>$events]);
    }


    // details front
    /**
     * @Route("/navbar-v1-eventDetails/{id}", name="eventDetails")
     */
    public function DetailsEvents($id):Response
    {
        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);
        return $this->render('FrontOffice/navbar-v1-eventDetails.html.twig',['event'=>$event]);
    }





    // delete front
    /**
     * @Route ("/navbar-v2-events/{id}",name="deleteventfront")
     */
    public function deleteeventfront($id)
    {
        $em=$this->getDoctrine()->getManager();
        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);
        $event->setState("Deleted");
        $em->flush();
        return $this->redirectToRoute('navbar-v2-event');
    }




    // add event front

    /**
     * @Route("/addEvent", name="addevent")
     */
    public function addevent(Request $request): Response
    {
        dump($request);
        $event = new Event();
        $user = $this->getDoctrine()->getRepository(User::class)->find(10020855);
        $event->setTitleevent($request->get('TitleEvent'));
        $event->setContentevent($request->get('ContentEvent'));
        $event->setEventlocal($request->get('LocationEvent'));
        $dateD = new \DateTime($request->get('DateDebut'));
        $dateF = new \DateTime($request->get('DateFin'));
        $event->setDatedebut($dateD);
        $event->setDatefin($dateF);
        $event->setIdorganizer($user);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($event);
            $manager->flush();

        return $this->redirectToRoute('navbar-v2-events');
    }

    /**
     * @Route("/editevent", name="editevent")
     */
  /*  public function editevent(Request $request, Event $event, EventRepository $eventRepository): Response
    {
        $form= $this->createForm();


    }*/



    /* ******************* Participate ******************* */
               /* *********** BACK *********** */




    ////participate list back
    /**
     * @Route ("/ParticipateListEvents{id}",name="ParticipateList")
     */
    public function ParticipateList($id):Response
    {
        $participates= $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);
        return $this->render('BackOffice/ParticipatesDashboard.html.twig',['participates'=>$participates->getCinuser()]);
    }


                 /* *********** Front *********** */
    ////participate list Front
    /**
     * @Route ("/navbar-v2-events/ParticipateList/{id}",name="ParticipateListFront")
     */
    public function ParticipateListfront($id):Response
    {
        $participates= $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);
        return $this->render('FrontOffice/navbar-v2-participateList.html.twig',['participates'=>$participates->getCinuser()]);
    }




    //// add participate Front
    /**
     * @Route ("/navbar-v2-events/Participate/{id}",name="addParticipate")
     */
    public function addParticipate(Request $request , $id):Response
    {
        dump($request);
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find(1010101);


        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);
       // $nbPart= $event->getNbrparticipant();
        // $nbPart =$request->get('NbParticipate');
      //  $nbPart = $nbPart+1;
        //$event->setNbrparticipant($nbPart);


        $event->addCinuser($user);
        $em=$this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('navbar-v2-event');
    }


    // delete Part Front
    /**
     * @Route ("/navbar-v2-events/delPart/{id}",name="deleteParticipate")
     */
    public function deleteParticipate($id)
    {
        $em=$this->getDoctrine()->getManager();
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find(1010101);

        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);
        $event->removeCinuser($user);
        $em->flush();
        return $this->redirectToRoute('navbar-v2-event');
    }




       /* *************** metier ********************** */
    ////Location event list Front
    /**
     * @Route ("/navbar-v2-events/Participate/locationList/{id}",name="locationList")
     */
    public function LocationListfront($cin=1010101):Response
    {
        $participates= $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($cin);

        return $this->render('FrontOffice/navbar-v1-eventDetails.html.twig',['participates'=>$participates->getEventlocal()]);
    }

    /**
     * @Route("/api/rechercheEventIdTitleLocal/{id}/{title}/{local}", name="rechercheEventIdTitleLocal", methods={"GET"})
     */
    public function rechercheEventIdTitleLocal($id, $title, $local, SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $events=$em->createQueryBuilder()
            ->select('e.idevent,e.titleevent,e.contentevent,e.contentevent,e.eventlocal,e.nbrparticipant,e.datedebut,e.datefin,u.cinuser AS idOrganizer')
            ->from('App\Entity\Event','e')
            ->innerJoin('App\Entity\User','u','with', "u.cinuser = e.idorganizer")
            ->where('e.idevent=:id')
            ->andWhere('e.titleevent=:title')
            ->andWhere('e.eventlocal=:local')
            ->setParameters(array('id'=>$id,'title'=>$title,'local'=>$local))
            ->getQuery()
            ->getArrayResult();
        $json = $serializer->serialize($events, 'json', ['groups' => '$events']);
        $Response = new Response($json);
        return $Response;
    }




}
