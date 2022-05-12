<?php

namespace App\Controller;

use App\Entity\Alert;
use App\Entity\Annoncement;
use App\Entity\Catannonce;
use App\Entity\Event;
use App\Entity\User;
use App\Entity\Catalert;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use App\Services\SessionManagmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AnnoncementRepository;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\Persistence\ManagerRegistry;

class  AnnoncementController extends AbstractController
{


    /**
     * @Route("/announcementDashboard",name="announcementDashboard")
     */
    public function GetAnnoucement():Response{
        $announcement=$this->getDoctrine()
            ->getRepository(Annoncement::class)
            ->findAll();
        return $this->render('BackOffice/AnnounceDashboard.html.twig',[
           'announcement'=>$announcement
        ]);
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
        public function addAnnounce(Request $request,SessionManagmentService $sessionManagmentService): Response
        {
            dump($request);
            if ($request->request->count() > 0) {
                $announce=new Annoncement();
                $announce->setSubject($request->get('subject'));
                $currentUser=$sessionManagmentService->getUser();
                $user=$this->getDoctrine()->getRepository(User::class)->find($currentUser->getCinuser());
                echo $user->getLastname()." ".$user->getFirstname();
                $announce->setIdsender($user);
                $announce->setCreatedat(new \DateTime('@' . strtotime('now')));
                $announce->setContent($request->get('content'));
                $announce->setDestination($request->get('destination'));//libCatAnn
                $catAnn=$this->getDoctrine()->getRepository(Catannonce::class)->findOneBy(['libcatann'=>$request->get('Category')]);
                $announce->setCatann($catAnn);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($announce);
                $manager->flush();
                return $this->redirectToRoute('announcementDashboard',[]);
            }

            return $this->render('BackOffice/AddNewAnnounce.html.twig', [
            ]);
        }

    /* *********** FRONT *********** */

    // affichage front

    /* *********** FRONT *********** */

    // affichage front
    /**
     * @Route("/announceFront", name="announceFront")
     */
    public function getlistann():Response
    {
        $ann = $this->getDoctrine()
            ->getRepository(Annoncement::class)
            ->findByStateField('Active');
        $alerts = $this->getDoctrine()
            ->getRepository(Alert::class)
            ->findByExampleField('Active');

        return $this->render('FrontOffice/announceFront.html.twig',
            array('alerts'=>$alerts,
            'ann'=>$ann)
            );
    }

    /**
     * @Route("/addalert", name="addalert")
     */
    public function addalert(Request $request): Response
    {
        dump($request);
        $alert = new Alert();
        $catalert=new Catalert();

        $user = $this->getDoctrine()->getRepository(User::class)->find(10020855);
        $alert->setAlerttitle($request->get('SubjectAlert'));
        $alert->setContent($request->get('ContentAlert'));
        $catalert->setLibcatalert($request->get('CatAlert'));
        $alert->setCatalert($catalert);
        $alert->setDestclass($request->get('DestAlert'));
        $alert->setCreatedat(new \DateTime('@' . strtotime('now')));
        $alert->setIdsender($user);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($catalert);
        $manager->persist($alert);
        $manager->flush();

        return $this->redirectToRoute('announceFront');
    }


    /**
     * @Route("/SearchMultipleChoice", name="SearchMultipleChoice" , methods={"GET", "POST"})
     */
    public function getlistannn(Request $request ,PaginatorInterface $paginator): Response
    {
        dump($request);
        $title = $request->get('title');
        $dest = $request->get('destination');
        $data = [];
        $data1=[];
        if($title != "" || $dest!="") {
            $data = $this->getDoctrine()
                ->getRepository(Annoncement::class)
                ->findBytitle($title,$dest);
            $data1 = $this->getDoctrine()
                ->getRepository(Alert::class)
                ->findBytitle($title,$dest);
        } else {
            $data= $this->getDoctrine()
                ->getRepository(Annoncement::class)
                ->findAll();
            $data1= $this->getDoctrine()
                ->getRepository(Alert::class)
                ->findAll();
        }


        $ann= $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            4
        );
        $alerts= $paginator->paginate(
            $data1,
            $request->query->getInt('page',1),
            4
        );

        return $this->render('FrontOffice/announceFront.html.twig',['ann'=>$ann ,'alerts'=>$alerts ]);
    }

    /**
     * @Route("/GeneratePdfAnnounce", name="GeneratePdfAnnounce")
     */
    public function getListPDF(AnnoncementRepository $annoncementRepository):Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        $announces = $annoncementRepository->findAll();

        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('FrontOffice/announcePDF.html.twig',['announces'=>$announces]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("AnnouncesList.pdf", [
            "Attachment" => true
        ]);

        exit(0);
    }


    /**
     * @Route("/test5", name="test5")
     */
    public function test():Response
    {
        $ann = $this->getDoctrine()
            ->getRepository(Event::class)
            ->findAll();

        dump($ann);
        //dump($ann['idsender']);
       // echo $ann->getIdsender()->getCinuser();
        die;
    }


    /**
     * @Route("/api/getanns", name="annoucementList", methods={"GET"})
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
     * @Route("/api/addannounce", name="addAnnounceApi")
     */
    public function addAnnounceApi(Request $request, SerializerInterface $serializer)
    {
        try {
            $user = $this->getDoctrine()->getRepository(User::class)->find($request->get("idowner"));
            $announce=new Annoncement();
            $date = new \DateTime('@' . strtotime('now'));
            $announce->setCreatedat($date);
            $announce->setSubject($request->get("subject"));//$content['title']
            $announce->setContent($request->get("content"));//$content['content']
            $announce->setDestination($request->get("destination"));//$content['categorieforum']
            $announce->setIdsender($user);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($announce);
            $manager->flush();
            return new Response('Added to DataBase',200);

        } catch
        (\Exception $exception) {
            return new Response("not added");
        }


    }


    /**
     * @Route("/api/deleteannounce/{id}", name="deleteAnnounceApi")
     */
    public function deleteAnnounceApi($id, Request $request, SerializerInterface $serializer)
    {
        try {
            $announce = $this->getDoctrine()->getRepository(Annoncement::class)->find($id);
            $announce->setState('Deleted');
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($announce);
            $manager->flush();
            return new Response('Deleted',200);

        } catch
        (\Exception $exception) {
            return new Response("not added");
        }


    }



}
