<?php

namespace App\Controller;

use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavigationFrontOfficeController extends AbstractController
{
    /**
     * @Route("/login", name="Login")
     */
    public function login(): Response
    {
        return $this->render('FrontOffice/login.html.twig', [
            'controller_name' => 'NavigationFrontOfficeController',
        ]);
    }


    /**
     * @Route("/navbar-v2-announces", name="navbar-v2-announces")
     */
    public function announces(): Response
    {
        return $this->render('FrontOffice/navbar-v2-announces.html.twig', [
            'controller_name' => 'NavigationFrontOfficeController',
        ]);
    }
    /**
     * @Route("/navbar-v2-events", name="navbar-v2-events")
     */
    public function events(): Response
    {
        return $this->render('FrontOffice/navbar-v2-events.html.twig', [
            'controller_name' => 'NavigationFrontOfficeController',
        ]);
    }

    /**
     * @Route("/navbar-v2-forums", name="navbar-v2-forums")
     */
    public function forums(): Response
    {
        return $this->render('FrontOffice/navbar-v2-forums.html.twig', [
            'controller_name' => 'NavigationFrontOfficeController',
        ]);
    }

    /**
     * @Route("/navbar-v2-offres", name="navbar-v2-offres")
     */
    public function offres(): Response
    {
        return $this->render('FrontOffice/navbar-v2-offres.html.twig', [
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
     * @Route("/userProfile", name="userProfile")
     */
    public function profil(): Response
    {

        return $this->render('FrontOffice/navbar-v2-profile-main.html.twig', [
            'user' => 'bairem',
        ]);
    }

    /**
     * @Route("/register", name="userProfile")
     */
    public function register(): Response
    {

        return $this->render('FrontOffice/register.html.twig', [
        ]);
    }

}
