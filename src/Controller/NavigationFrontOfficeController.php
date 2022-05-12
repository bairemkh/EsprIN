<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavigationFrontOfficeController extends AbstractController
{



    /**
     * @Route("/navbar-v2-announces", name="navbar-v2-announces")
     */
    public function announces(): Response
    {
        return $this->render('FrontOffice/announceFront.html.twig', [
            'controller_name' => 'NavigationFrontOfficeController',
        ]);
    }
    /**
     * @Route("/navbar-v2-events", name="navbar-v2-events")
     */
    public function events(): Response
    {
        return $this->render('FrontOffice/eventsFront.html.twig', [
            'controller_name' => 'NavigationFrontOfficeController',
        ]);
    }

    /**
     * @Route("/navbar-v2-forums", name="navbar-v2-forums")
     */
    public function forums(): Response
    {
        return $this->render('FrontOffice/forumFront.html.twig', [
            'controller_name' => 'NavigationFrontOfficeController',
        ]);
    }

    /**
     * @Route("/navbar-v2-offres", name="navbar-v2-offres")
     */
    public function offres(): Response
    {
        return $this->render('FrontOffice/offreFront.html.twig', [
            'controller_name' => 'NavigationFrontOfficeController',
        ]);
    }

    /**
     * @Route("/navbar-v2-feed", name="navbar-v2-feed")
     */
    public function feed(): Response
    {
        return $this->render('FrontOffice/navbar-v2-feed.html.twig', [
            'controller_name' => 'NavigationFrontOfficeController',
        ]);
    }

    /**
         * @Route("/register", name="register")
         */
        public function register(): Response
        {
            return $this->render('FrontOffice/register.html.twig', [
                'controller_name' => 'NavigationFrontOfficeController',
            ]);
        }

}
