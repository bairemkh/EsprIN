<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardBackOfficeController extends AbstractController
{
    /**
     * @Route("/BackOffice", name="app_dashboard_back_office")
     */
    public function index(): Response
    {
        return $this->render('BackOffice/index.html.twig',[
                'controller_name'=>'DashboardBackOfficeController',
            ]
        );
    }
    /**
     * @Route ("/AddNewUser",name="AddNewUser")
     */
    public function adduser():Response{
        return $this->render('BackOffice/AddNewUser.html.twig',[
            'controller_name'=>'DashboardBackOfficeController',
            ]
        );
    }


/**
 * @Route ("/AddNewAnnounce",name="AddNewAnnounce")
 */
public function addannounce():Response{
    return $this->render('BackOffice/AddNewAnnounce.html.twig',[
    'controller_name'=>'DashboardBackOfficeController',
        ]
    );
}

    /**
     * @Route ("/AlertDashboard",name="AlertDashboard")
     */
    public function AlertDashboard():Response{
        return $this->render('BackOffice/AlertDashboard.html.twig',[
                'controller_name'=>'DashboardBackOfficeController',
            ]
        );
    }

    /**
     * @Route ("/AnnounceDashboard",name="AnnounceDashboard")
     */
    public function AnnounceDashboard():Response{
        return $this->render('BackOffice/AnnounceDashboard.html.twig',[
                'controller_name'=>'DashboardBackOfficeController',
            ]
        );
    }

    /**
     * @Route ("/CommentsDashboard",name="CommentsDashboard")
     */
    public function CommentsDashboard():Response{
        return $this->render('BackOffice/CommentsDashboard.html.twig',[
                'controller_name'=>'DashboardBackOfficeController',
            ]
        );
    }

    /**
     * @Route ("/EventsDashboard",name="EventsDashboard")
     */
    public function EventsDashboard():Response{
        return $this->render('BackOffice/EventsDashboard.html.twig',[
                'controller_name'=>'DashboardBackOfficeController',
            ]
        );
    }

    /**
     * @Route ("/ParticipatesDashboard",name="ParticipatesDashboard")
     */
    public function ParticipatesDashboard():Response{
        return $this->render('BackOffice/ParticipatesDashboard.html.twig',[
                'controller_name'=>'DashboardBackOfficeController',
            ]
        );
    }

    /**
     * @Route ("/ForumDashboard",name="ForumDashboard")
     */
    public function ForumDashboard():Response{
        return $this->render('BackOffice/ForumDashboard.html.twig',[
                'controller_name'=>'DashboardBackOfficeController',
            ]
        );
    }

    /**
     * @Route ("/OfferDashboard",name="OfferDashboard")
     */
    public function OfferDashboard():Response{
        return $this->render('BackOffice/OfferDashboard.html.twig',[
                'controller_name'=>'DashboardBackOfficeController',
            ]
        );
    }

    /**
     * @Route ("/PostDashboard",name="PostDashboard")
     */
    public function PostDashboard():Response{
        return $this->render('BackOffice/PostDashboard.html.twig',[
                'controller_name'=>'DashboardBackOfficeController',
            ]
        );
    }

    /**
     * @Route ("/UserDashboard",name="UserDashboard")
     */
    public function UserDashboard():Response{
        return $this->render('BackOffice/UserDashboard.html.twig',[
                'controller_name'=>'DashboardBackOfficeController',
            ]
        );
    }


}
