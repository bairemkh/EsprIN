<?php

namespace App\Controller;

use App\Entity\Alert;
use App\Entity\Catalert;
use App\Repository\AlertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
    public function listAlert(AlertRepository $alertRepository)
    {

        $alerts = $alertRepository->findAll();
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($alerts, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->setIdalert();
            }
        ]);

        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }













    /**
     * @Route("/api/updateAlertAPI/{id}", name="updateAlertAPI")
     */
    public function updateAlertAPI(Alert $alert, Request $request, $id)
    {
        try {

            $content=$request->getContent();
            $alerts=json_decode($content,true);
            $alert = $this->getDoctrine()->getManager()->getRepository(Alert::class)->find($id);
            $alert->setAlerttitle($alert['alerttitle']);
            $alert->setContent($alert['content']);
            $alert->setDestclass($alert['destclass']);
            $alert->setCreatedat(new \DateTime('@' . strtotime('now')));
            $user=$this->getDoctrine()->getRepository(User::class)->findOneBy(['cinuser'=>$alert['idsender']]);
            $alert->setIdsender($user);
            $catalert=$this->getDoctrine()->getRepository(Catalert::class)->findOneBy(['cinuser'=>$alert['catalert']]);
            $alert->setIdsender($catalert);
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return new Response('update to DataBase',200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }
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
