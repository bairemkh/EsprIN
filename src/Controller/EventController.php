<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Participate;
use App\Entity\User;
use App\Repository\EventRepository;
use App\Services\SessionManagmentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Date;

class EventController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
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
    /* ******************* EVENT ******************* */
    /* *********** BACK *********** */

    //affichage back
    /**
     * @Route ("/EventsDashboard",name="EventsDashboard")
     */
    public function getEvents(): Response
    {
        $events = $this->getDoctrine()
            ->getRepository(Event::class)
            ->findByExampleField('Active');
        return $this->render('BackOffice/EventsDashboard.html.twig', ['events' => $events]);
    }

    // delete back

    /**
     * @Route ("/EventsDashboard/{id}",name="deleteevent")
     */
    public function deleteevent($id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);
        $event->setState("Deleted");
        $em->flush();
        return $this->redirectToRoute('EventsDashboard');
    }


    /**
     * @Route("/eventsFront/ShowByDateAsc", name="ShowByDateAsc")
     */
    public function ShowByDateAsc(EventRepository $eventRepository)
    {
        $events = $eventRepository->sortByDateAsc();
        dump($events);
        return $this->render('BackOffice/EventsDashboard.html.twig', ['events' => $events]);

    }

    /**
     * @Route("/eventsFront/ShowByDateDesc", name="ShowByDateDesc")
     */
    public function ShowByDateDesc(EventRepository $eventRepository)
    {
        $events = $eventRepository->sortByDateDesc();
        dump($events);
        return $this->render('BackOffice/EventsDashboard.html.twig', ['events' => $events]);

    }



    /* *********** FRONT *********** */

    // affichage front
    /**
     * @Route("/eventsFront", name="eventsFront")
     */
    public function getlistevents(): Response
    {
        $events = $this->getDoctrine()
            ->getRepository(Event::class)
            ->findByExampleField('Active');
        return $this->render('FrontOffice/eventsFront.html.twig', ['events' => $events]);
    }


    // details front

    /**
     * @Route("/navbar-v1-eventDetails/{id}", name="eventDetails")
     */
    public function DetailsEvents($id): Response
    {
        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);
        return $this->render('FrontOffice/navbar-v1-eventDetails.html.twig', ['event' => $event]);
    }





    // delete front

    /**
     * @Route ("/eventsFront/{id}",name="deleteventfront")
     */
    public function deleteeventfront($id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);
        $event->setState("Deleted");
        $em->flush();
        return $this->redirectToRoute('eventsFront');
    }




    // add event front

    /**
     * @Route("/addEvent", name="addevent")
     */
    public function addevent(Request $request,SessionManagmentService $sessionManagmentService): Response
    {
        dump($request);
        $event = new Event();
        $currentUser=$sessionManagmentService->getUser();
        $user = $this->getDoctrine()->getRepository(User::class)->find($currentUser->getCinuser());
        $event->setTitleevent($request->get('TitleEvent'));
        $event->setContentevent($request->get('ContentEvent'));
        $event->setEventlocal($request->get('LocationEvent'));
        $dateD = new \DateTime($request->get('DateDebut'));
        $dateF = new \DateTime($request->get('DateFin'));
        $event->setDatedebut($dateD);
        $event->setDatefin($dateF);
        $uploadedFile =$request->get('imgURL');
        if ($uploadedFile) {
            $destination = $this->getParameter('kernel.project_dir') . '\public\images\events';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->move(
                $destination,
                $newFilename);
            $event->setImgurl($newFilename);
        }
        $event->setIdorganizer($user);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($event);
        $manager->flush();

        return $this->redirectToRoute('eventsFront');
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
     * @Route ("/ParticipateListEvents/{id}",name="ParticipateList")
     */
    public function ParticipateList($id):Response
    {
        $participates= $this->getDoctrine()
            ->getRepository(Participate::class)
            ->findAll();
//        dd($participates);
        return $this->render('BackOffice/ParticipatesDashboard.html.twig',['participates'=>$participates,'id'=>$id]);
    }


    /* *********** Front *********** */
    ////participate list Front
    /**
     * @Route ("/eventsFront/ParticipateList/{id}",name="ParticipateListFront")
     */
    public function ParticipateListfront($id): Response
    {
        $participates = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);
        return $this->render('FrontOffice/navbar-v2-participateList.html.twig', ['participates' => $participates->getCinuser()]);
    }




    //// add participate Front

    /**
     * @Route ("/eventsFront/Participate/{id}",name="addParticipate")
     */
    public function addParticipate(Request $request, $id,SessionManagmentService $sessionManagmentService): Response
    {$currentUser=$sessionManagmentService->getUser();
        dump($request);
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($currentUser->getCinuser());


        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);
        $event->addCinuser($user);
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('eventsFront');
    }


    // delete Part Front

    /**
     * @Route ("/eventsFront/delPart/{id}",name="deleteParticipate")
     */
    public function deleteParticipate($id,SessionManagmentService $sessionManagmentService)
    {
        $currentUser=$sessionManagmentService->getUser();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($currentUser->getCinuser());

        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);
        $event->removeCinuser($user);
        $em->flush();
        return $this->redirectToRoute('eventsFront');
    }




    /* *************** metier ********************** */
    ////Location event list Front
    /**
     * @Route ("/eventsFront/Participate/locationList/{id}",name="locationList")
     */
    public function LocationListfront($cin): Response
    {
        $participates = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($cin);

        return $this->render('FrontOffice/navbar-v1-eventDetails.html.twig', ['participates' => $participates->getEventlocal()]);
    }


    /**
     * @Route ("/navbar-v1-LocationEvents",name="EventByParticipate")
     */
    public function EventByParticipate(EventRepository $eventRepository): Response
    {

        $events = $eventRepository->findByParticipate();
        dump($events);


        return $this->render('FrontOffice/navbar-v1-LocationEvents.html.twig', ['eventsPart' => $events]);
    }

    /**
     * @Route ("/navbar-v1-LocationEvents/{id}",name="ShowLocation")
     */
    /*  public function ShowLocation(Request $request ,$id):Response
      {


      }*/

    /**
     * @Route ("/eventsFront/notif",name="sendEmail")
     */
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('khedhribairem@gmail.com')
            ->to('eya.kasmi@esprit.tn')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('notification!')
            // ->text('Sending emails is fun again!')
            ->html('<p>vous aver participer a un evenement!!</p>');


        $mailer->send($email);
        return $this->redirectToRoute('eventsFront');

    }


    /**
     * @Route ("api/getevents",name="get-events-api")
     */
    public function geteventApi(SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        /* $events = $this->getDoctrine()
             ->getRepository(Event::class)
             ->findAll();*/
        $events = $em->createQueryBuilder()
            ->select('e.idevent,e.titleevent,e.contentevent,e.contentevent,e.eventlocal,e.nbrparticipant,e.datedebut,e.datefin,u.cinuser AS idOrganizer')
            ->from('App\Entity\Event', 'e')
            ->innerJoin('App\Entity\User', 'u', 'with', "u.cinuser = e.idorganizer")
            ->getQuery()
            ->getArrayResult();
        $json = $serializer->serialize($events, 'json', ['groups' => 'events']);
        $Response = new Response($json);
        return $Response;
    }

    /**
     * @Route ("api/getevent/{id}",name="getEventById")
     */
    public function getEventByIdApi($id, SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        /* $events = $this->getDoctrine()
             ->getRepository(Event::class)
             ->findAll();*/
        $events = $em->createQueryBuilder()
            ->select('e.idevent,e.titleevent,e.contentevent,e.contentevent,e.eventlocal,e.nbrparticipant,e.datedebut,e.datefin,u.cinuser AS idOrganizer')
            ->from('App\Entity\Event', 'e')
            ->innerJoin('App\Entity\User', 'u', 'with', "u.cinuser = e.idorganizer")
            ->where('e.idevent=:id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getArrayResult();
        $json = $serializer->serialize($events, 'json', ['groups' => 'events']);
        $Response = new Response($json);
        return $Response;
    }

    /**
     * @Route("/api/addevent", name="addEventApi")
     */
    public function addeventApi(Request $request, SerializerInterface $serializer)
    {
        try {
            $event = new Event();
            $json = $request->getContent();
            $content = json_decode($json, true);
            $user = $this->getDoctrine()->getRepository(User::class)->find($content['idOrganizer']);
            $event->setTitleevent($content['titleEvent']);
            $event->setContentevent($content['contentEvent']);
            $event->setEventlocal($content['locationEvent']);
            $dateD = new \DateTime($content['dateDebut']);
            $dateF = new \DateTime($content['dateFin']);
            $event->setDatedebut($dateD);
            $event->setDatefin($dateF);
            $event->setIdorganizer($user);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($event);
            $manager->flush();
            return new Response('Added to DataBase', 200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }


    }

    public function setEventCard(): Response
    {
        $event = $this->entityManager->createQueryBuilder()
            ->select('e.titleevent,u.firstname,u.lastname,u.imgurl')
            ->from('App\Entity\Event', 'e')
            ->innerJoin('App\Entity\User', 'u', 'with', "u.cinuser = e.idorganizer")
            ->orderBy('e.idevent', 'desc')
            ->getQuery()
            ->getArrayResult();
        return $this->render('FrontOffice/cells/NewEventCell.html.twig', [
            'event' => $event[0],
        ]);
    }
}
