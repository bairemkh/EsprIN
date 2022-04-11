<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontOfficeController extends AbstractController
{
    /**
     * @Route("/", name="postfront")
     */
    public function default(): Response
    {
        return $this->render('FrontOffice/navbar-v2-feed.html.twig',[
                'controller_name'=>'FrontOfficeController',
            ]
        );
    }
    /**
     * @Route("/events", name="eventfront")
     */
    public function getevent(): Response
    {
        return $this->render('FrontOffice/navbar-v2-events.html.twig');
    }

    /**
     * @Route("/annouces", name="annoucefront")
     */
    public function getannouce(): Response
    {
        return $this->render('FrontOffice/navbar-v2-announces.html.twig',[
                'controller_name'=>'FrontOfficeController',
            ]
        );
    }

    /**
     * @Route("/forums", name="forumsfront")
     */
    public function getforums(): Response
    {
        return $this->render('FrontOffice/navbar-v2-forums.html.twig',[
                'controller_name'=>'FrontOfficeController',
            ]
        );
    }

    /**
     * @Route("/offres", name="offrefront")
     */
    public function getoffres(): Response
    {
        return $this->render('FrontOffice/navbar-v2-offres.html.twig',[
                'controller_name'=>'FrontOfficeController',
            ]
        );
    }


    /**
     * @Route("/front/office", name="app_front_office")
     */
    public function index(): Response
    {
        return $this->render('front_office/index.html.twig', [
            'controller_name' => 'FrontOfficeController',
        ]);
    }
}
