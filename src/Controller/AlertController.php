<?php

namespace App\Controller;

use App\Entity\Alert;
use App\Entity\Catalert;
use App\Entity\Event;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AlertController extends AbstractController
{
    /**
     * @Route ("/AlertDashboard",name="AlertDashboardd")
     */
    public function getAlertes():Response{
        $alerts= $this->getDoctrine()
            ->getRepository(Alert::class)
            ->findByExampleField('Active');
        return $this->render('BackOffice/AlertDashboard.html.twig',['alerts'=>$alerts]);
    }
    /**
     * @Route("/alert", name="app_alert")
     */
    public function index(): Response
    {
        return $this->render('alert/index.html.twig', [
            'controller_name' => 'AlertController',
        ]);
    }

    /**
     * @Route ("api/getalerts",name="getalerts")
     */
    public function getAlertsApi(SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $alerts=$em->createQueryBuilder()
            ->select('a.idalert,c.libcatalert,a.alerttitle,a.content,a.destclass,u.cinuser as Idsender,a.createdat')
            ->from('App\Entity\Alert','a')
            ->innerJoin('App\Entity\User','u','with', "u.cinuser = a.idsender")
            ->innerJoin('App\Entity\catalert','c','with', "a.catalert = c.idcatalert")
            ->getQuery()
            ->getArrayResult();
        $json = $serializer->serialize($alerts, 'json', ['groups' => 'alerts']);
        $Response = new Response($json);
        return $Response;
    }

    /**
     * @Route ("api/getalert/{id}",name="getalertById")
     */
    public function getAlertByIdApi($id,SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $alerts=$em->createQueryBuilder()
            ->select('a.idalert,c.libcatalert,a.alerttitle,a.content,a.destclass,u.cinuser as Idsender,a.createdat')
            ->from('App\Entity\Alert','a')
            ->innerJoin('App\Entity\User','u','with', "u.cinuser = a.idsender")
            ->innerJoin('App\Entity\catalert','c','with', "a.catalert = c.idcatalert")
            ->where('a.idalert=:id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getArrayResult();
        $json = $serializer->serialize($alerts, 'json', ['groups' => 'alerts']);
        $Response = new Response($json);
        return $Response;
    }

    /**
     * @Route("/api/addAlert", name="addAlert")
     */
    public function addAlertApi(Request $request)
    {
        try {
            $alert=new Alert();
            $json=$request->getContent();
            $content=json_decode($json,true);
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['cinuser'=>$content['Idsender']]);
            $catAlert = $this->getDoctrine()->getRepository(Catalert::class)->findOneBy(['libcatalert'=>$content['libcatalert']]);
            $alert->setAlerttitle($content['alerttitle']);
            $alert->setContent($content['content']);
            $alert->setDestclass($content['destclass']);
            $date = new \DateTime('@' . strtotime('now'));
            $alert->setCreatedat($date);
            $alert->setIdsender($user);
            $alert->setCatalert($catAlert);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($alert);
            $manager->flush();
            return new Response('Added to DataBase',200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }


    }
}
