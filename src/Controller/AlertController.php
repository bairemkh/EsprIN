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
    public function listAlert(AlertRepository $alertRepository)
    {

        // bil find all
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

        // bil joiture : ti5dimich 5atir joiture ta3 il catAlert bou zouz 3raftich na3malha
/*    public function listAlert(SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $alerts=$em->createQueryBuilder()
            ->select('a.idalert,a.alerttitle,a.content,a.destclass,a.createdat, c.idCatAlert AS catalert, c.cinuser AS idsender')
            ->from('App\Entity\Alert','a')
            ->innerJoin('App\Entity\User','u','with', "u.cinuser = a.idsender")
            ->innerJoin('App\Entity\Catalert','c','with','c.idCatAlert = a.catalert')
            ->getQuery()
            ->getArrayResult();
        $json = $serializer->serialize($alerts, 'json', ['groups' => '$alerts']);
        $Response = new Response($json);
        return $Response;*/
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
