<?php

namespace App\Controller;

use App\Entity\Alert;
use App\Entity\Catalert;
use App\Repository\AlertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
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


    //////Api

    /**
     * @Route("/api/listAlert", name="listAlert", methods={"GET"})
     */
    public function listAlert(SerializerInterface $serializer, EntityManagerInterface $em): Response
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
     * @Route("/api/rechercheAlertTitleContentDestination/{title}/{content}/{destination}", name="rechercheAlertTitleContentDestination", methods={"GET"})
     */
    public function rechercheAlertTitleContentDestination($title, $content, $destination, SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $offres=$em->createQueryBuilder()
            ->select('a.idalert,c.libcatalert,a.alerttitle,a.content,a.destclass,u.cinuser as Idsender,a.createdat')
            ->from('App\Entity\Alert','a')
            ->innerJoin('App\Entity\User','u','with', "u.cinuser = a.idsender")
            ->innerJoin('App\Entity\catalert','c','with', "a.catalert = c.idcatalert")
            ->where('a.alerttitle=:title')
            ->andWhere('a.content=:content')
            ->andWhere('a.destclass=:destination')
            ->setParameters(array('title'=>$title,'content'=>$content,'destination'=>$destination))
            ->getQuery()
            ->getArrayResult();
        $json = $serializer->serialize($offres, 'json', ['groups' => '$offres']);
        $Response = new Response($json);
        return $Response;
    }


    /**
     * @Route("/api/deleteAlertApi/{id}", name="deleteAlertApi")
     */
    public function deleteAlertApi(Alert $alert, Request $request, $id)
    {
        try {

            $content=$request->getContent();
            $alerts=json_decode($content,true);
            $alert = $this->getDoctrine()->getManager()->getRepository(Alert::class)->find($id);
            $alert->setState('Deleted');
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return new Response('Deleted',200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }
    }
}
