<?php

namespace App\Controller;

use App\Entity\Annoncement;
use App\Entity\Catannonce;
use App\Entity\User;
use App\Repository\AnnoncementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class AnnoncementController extends AbstractController
{
    /**
     * @Route ("/AnnounceDashboard",name="AnnounceDashboard")
     */
    public function getAnnounces():Response{
        $announces= $this->getDoctrine()
            ->getRepository(Annoncement::class)
            ->findByStateField('Active');
        return $this->render('BackOffice/AnnounceDashboard.html.twig',['announces'=>$announces]);
    }
    /**
     * @Route("/annoncement", name="app_annoncement")
     */
    public function index(): Response
    {
        return $this->render('annoncement/index.html.twig', [
            'controller_name' => 'AnnoncementController',
        ]);
    }

    /**
     * @Route("/AnnounceDashboard/{id}", name="deleteannounce")
     */
    public function delete($id)
    {
        $em=$this->getDoctrine()->getManager();
        $post = $this->getDoctrine()
            ->getRepository(Annoncement::class)
            ->find($id);
        $post->setState("Deleted");
        $em->flush();
        return $this->redirectToRoute('AnnounceDashboard');
    }

        /**
         * @Route("/addAnnoncement", name="add_new_annoncement", methods={"GET", "POST"})
         */
        public function addAnnounce(Request $request): Response
        {
            dump($request);
            if ($request->request->count() > 0) {
                $announce=new Annoncement();
                $announce->setSubject($request->get('subject'));
                $user=$this->getDoctrine()->getRepository(User::class)->find(10020855);
                echo $user->getLastname()." ".$user->getFirstname();
                $announce->setIdsender($user);
                $announce->setCreatedat(new \DateTime('@' . strtotime('now')));
                $announce->setContent($request->get('content'));
                $announce->setDestination($request->get('destination'));//libCatAnn
                $catAnn=$this->getDoctrine()->getRepository(Catannonce::class)->findOneBy(['libcatann'=>$request->get('Category')]);
                $announce->setCatann($catAnn->getIdcatann());
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($announce);
                $manager->flush();
                return $this->redirectToRoute('AnnounceDashboard',[]);
            }

            return $this->render('BackOffice/AddNewAnnounce.html.twig', [
            ]);
        }



        /////Api


    /**
     * @Route("/api/annoucementList", name="annoucementList", methods={"GET"})
     */
    public function annoncementList(SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $annoncements=$em->createQueryBuilder()
            ->select('a.idann, a.subject, a.content, a.destination, a.createdat, a.catann, u.cinuser AS idsender')
            ->from('App\Entity\Annoncement','a')
            ->innerJoin('App\Entity\User','u','with', "u.cinuser = a.idsender")
            ->getQuery()
            ->getArrayResult();
        $json = $serializer->serialize($annoncements, 'json', ['groups' => '$annoncements']);
        $Response = new Response($json);
        return $Response;
    }


    /**
     * @Route("/api/rechercheAnnoncementIdSubjectDestination/{id}/{subject}/{destination}", name="rechercheAnnoncementIdSubjectDestination", methods={"GET"})
     */
    public function rechercheAnnoncementIdSubjectDestination( $id, $subject, $destination, SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $annoncements=$em->createQueryBuilder()
            ->select('a.idann, a.subject, a.content, a.destination, a.createdat, a.catann, u.cinuser AS idsender')
            ->from('App\Entity\Annoncement','a')
            ->innerJoin('App\Entity\User','u','with', "u.cinuser = a.idsender")
            ->Where('a.idann=:id')
            ->andWhere('a.subject=:subject')
            ->andWhere('a.destination=:destination')
            ->setParameters(array('id'=>$id,'subject'=>$subject,'destination'=>$destination))
            ->getQuery()
            ->getArrayResult();
        $json = $serializer->serialize($annoncements, 'json', ['groups' => '$annoncements']);
        $Response = new Response($json);
        return $Response;
    }

    /**
     * @Route("/api/rechercheAnnoncementId/{id}/", name="rechercheAnnoncementId", methods={"GET"})
     */
    public function rechercheAnnoncementId( $id, SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $annoncements=$em->createQueryBuilder()
            ->select('a.idann, a.subject, a.content, a.destination, a.createdat, a.catann, u.cinuser AS idsender')
            ->from('App\Entity\Annoncement','a')
            ->innerJoin('App\Entity\User','u','with', "u.cinuser = a.idsender")
            ->Where('a.idann=:id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getArrayResult();
        $json = $serializer->serialize($annoncements, 'json', ['groups' => '$annoncements']);
        $Response = new Response($json);
        return $Response;
    }


    /**
     * @Route("/api/addAnnoncementApi", name="addAnnoncementApi")
     */
    public function addAnnoncementApi(Request $request, SerializerInterface $serializer)
    {
        try {

            $content=$request->getContent();
            $annoncements=json_decode($content,true);
            $annoncement = New Annoncement();
            $annoncement->setSubject($annoncements['subject']);
            $annoncement->setContent($annoncements['content']);
            $annoncement->setDestination($annoncements['destination']);
            $annoncement->setCreatedat(new \DateTime('@' . strtotime('now')));
            $user=$this->getDoctrine()->getRepository(User::class)->findOneBy(['cinuser'=>$annoncements['idsender']]);
            $annoncement->setIdsender($user);
            $catAnn=$this->getDoctrine()->getRepository(Catannonce::class)->findOneBy(['libcatann'=>$request->get('Category')]);
            $annoncement->setCatann($catAnn->getIdcatann());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($annoncement);
            $manager->flush();
            return new Response('Added to DataBase',200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }


    }


    /**
     * @Route("/api/deleteannoncementApi/{id}", name="deleteannoncementApi")
     */
    public function deleteannoncementApi(Annoncement $annoncement, Request $request, $id)
    {
        try {

            $content=$request->getContent();
            $annoncements=json_decode($content,true);
            $annoncement = $this->getDoctrine()->getManager()->getRepository(Annoncement::class)->find($id);
            $annoncement->setState('Deleted');
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return new Response('Deleted',200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }
    }
}
