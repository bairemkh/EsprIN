<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\User;
use App\Form\InterestType;
use App\Repository\OffreRepository;
use App\Services\SessionManagmentService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\OffreType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\Persistence\ManagerRegistry;


class OffreController extends AbstractController
{
    /**
     * @Route ("/OfferDashboard",name="OfferDashboard")
     */
    public function getOffres():Response
    {
        $offres = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->findByState('Active');
        return $this->render('BackOffice/OfferDashboard.html.twig',['offres'=>$offres]);
    }

    /**
     * @Route("/offre", name="app_offre")
     */
    public function index(): Response
    {
        return $this->render('offre/index.html.twig', [
            'controller_name' => 'OffreController',
        ]);
    }

    /**
     * @Route("/offreFront", name="offreFront")
     */
    public function getListOffres(Request $request, PaginatorInterface $paginator):Response
    {
        $donnee = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->findAll();

        $offres = $paginator->paginate(
            $donnee,
            $request->query->getInt('page', 1),
            4
        );

        return $this->render('FrontOffice/offreFront.html.twig',['offres'=>$offres]);
    }

    /**
     * @Route("/deleteOffer/{id}", name="deleteOffer")
     */
    public function deleteOffer($id,SessionManagmentService $sessionManagmentService): Response
    {
        $em=$this->getDoctrine()->getManager();
        $currentUser=$sessionManagmentService->getUser();
        $user = $this->getDoctrine()->getRepository(User::class)->find($currentUser->getCinuser());
        $offer = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->find($id);
        $offer->setState("Deleted");
        $em->flush();
       return $this->redirectToRoute('profile', ['userCin' => $user->getCinuser()]);

    }


    /**
     * @Route("/deleteOfferBack/{id}", name="deleteOfferBack")
     */
    public function deleteOfferBack($id): Response
    {
        $em=$this->getDoctrine()->getManager();
        $offer = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->find($id);
        $offer->setState("Deleted");
        $em->flush();

        return $this->redirectToRoute('OfferDashboard');

    }

    /**
     * @Route("/addOffer", name="addOffer")
     */
    public function addOffer(Request $request,SessionManagmentService $sessionManagmentService): Response
    {
        $offre = new Offre();
        $form = $this->createForm(OffreType::class,$offre);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $currentUser=$sessionManagmentService->getUser();
            $user = $this->getDoctrine()->getRepository(User::class)->find($currentUser->getCinuser());
            $offre->setOfferprovider($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($offre);
            $em->flush();
            return $this->redirectToRoute('profile', ['userCin' => $user->getCinuser()]);
        }

        return $this->render('FrontOffice/addOffre.html.twig',['f'=>$form->createView()]);

    }



    /**
     * @Route("/updateOffer/{id}", name="updateOffer")
     */
    public function updateOffer(Request $request, $id,SessionManagmentService $sessionManagmentService): Response
    {
        $offre = $this->getDoctrine()->getManager()->getRepository(Offre::class)->find($id);
        $form = $this->createForm(OffreType::class,$offre);
        $currentUser=$sessionManagmentService->getUser();
        $user = $this->getDoctrine()->getRepository(User::class)->find($currentUser->getCinuser());
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('profile', ['userCin' => $user->getCinuser()]);
        }

        return $this->render('FrontOffice/updateOffre.html.twig',['f'=>$form->createView()]);

    }


    ////////


    /**
     * @Route ("/offreFront/Intrest/{id}",name="addIntrest")
     */
    public function addIntrest(Request $request , $id,SessionManagmentService $sessionManagmentService):Response
    {
        dump($request);
        $currentUser=$sessionManagmentService->getUser();
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($currentUser->getCinuser());

        $offre = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->find($id);

        $offre->addCinintrested($user);
        $em=$this->getDoctrine()->getManager();
        $em->flush();

        $em->flush();
        $this->addFlash(
            'info',
            'Intrest Added Successfully'
        );

        return $this->redirectToRoute('offreFront');
    }


    /**
     * @Route("/Generate Pdf", name="Generate Pdf")
     */
    public function getListPDF(OffreRepository $offreRepository):Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        $offres = $offreRepository->findAll();

        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('FrontOffice/offrePDF.html.twig',['offres'=>$offres]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("OffreList.pdf", [
            "Attachment" => true
        ]);

        exit(0);
    }

    /**
     * @Route("/stats", name="stats")
     */
    public function statistiques(OffreRepository $offreRepository)
    {
        // On va chercher toutes les menus
        $menus = $offreRepository->findAll();

//Data Category
        $state = "Active";
        $catoffre2 = "Offre de travail";
        $catoffre1 = "Stage";
        $catoffre = "Alternance";
        $Alternance = $offreRepository->createQueryBuilder('o')
            ->select('count(o.idoffer)')
            ->Where('o.catoffre= :catoffre')
            ->andWhere('o.state= :state')
            ->setParameters(array('catoffre'=>$catoffre,'state'=>$state))
            ->getQuery()
            ->getSingleScalarResult();

        $Stage = $offreRepository->createQueryBuilder('o')
            ->select('count(o.idoffer)')
            ->Where('o.catoffre= :catoffre')
            ->andWhere('o.state= :state')
            ->setParameters(array('catoffre'=>$catoffre1,'state'=>$state))
            ->getQuery()
            ->getSingleScalarResult();
        $Offre_de_travail = $offreRepository->createQueryBuilder('o')
            ->select('count(o.idoffer)')
            ->Where('o.catoffre= :catoffre')
            ->andWhere('o.state= :state')
            ->setParameters(array('catoffre'=>$catoffre2,'state'=>$state))
            ->getQuery()
            ->getSingleScalarResult();


        return $this->render('BackOffice/stats.html.twig', [
            'nAlternance' => $Alternance,
            'nStage' => $Stage,
            'nOffre_de_travail' => $Offre_de_travail,
        ]);

    }



    /**
     * @Route ("/OfferDashboard/{id}",name="deleteoffer")
     */
    public function delete($id)
    {
        $em=$this->getDoctrine()->getManager();
        $offer = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->find($id);
        $offer->setState("Deleted");
        $em->flush();
        return $this->redirectToRoute('OfferDashboard');
    }

    /**
     * @Route("/api/getoffers", name="offreList", methods={"GET"})
     */
    public function offreList(SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $offres=$em->createQueryBuilder()
            ->select('o.idoffer,o.titleoffer,o.descoffer,o.catoffre,u.cinuser AS offerprovider')
            ->from('App\Entity\Offre','o')
            ->innerJoin('App\Entity\User','u','with', "u.cinuser = o.offerprovider")
            ->getQuery()
            ->getArrayResult();
        $json = $serializer->serialize($offres, 'json', ['groups' => '$offres']);
        $Response = new Response($json);
        return $Response;
    }

    /**
     * @Route("/api/addOffer", name="addOfferApi")
     */
    public function addOfferApi(Request $request, SerializerInterface $serializer)
    {
        try {

            //$content=$request->getContent();
            //$offres=json_decode($content,true);
            $offre = New Offre();
            $offre->setTitleoffer($request->get('titleoffer'));//$offres['titleoffer']
            $offre->setDescoffer($request->get('descoffer'));//$offres['descoffer']
            $offre->setCatoffre($request->get('categorieoffer'));//$offre->setCatoffre();
            $user=$this->getDoctrine()->getRepository(User::class)
                ->find($request->get('offerprovider'));
            $offre->setOfferprovider($user);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($offre);
            $manager->flush();
            return new Response('Added to DataBase',200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }


    }

    /**
     * @Route("/api/updateoffre/{id}", name="updateoffreApi")
     */
    public function updateofftrApi(Request $request, SerializerInterface $serializer,$id)
    {
        try {
            $offre=$this->getDoctrine()->getRepository(Forum::class)->find($id);

            $offre->setTitleoffer($request->get('titleoffer'));//$offres['titleoffer']
            $offre->setDescoffer($request->get('descoffer'));//$offres['descoffer']
            $offre->setCatoffre($request->get('categorieoffer'));//$offre->setCatoffre();
            $user=$this->getDoctrine()->getRepository(User::class)
                ->find($request->get('offerprovider'));
            $offre->setOfferprovider($user);
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return new Response('updated to DataBase',200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }

    }

    /**
     * @Route ("/api/deleteoffre/{id}",name="deletoffreapi")
     */
    public function deleteoffreapi(Request $request, SerializerInterface $serializer,$id)
    {
        try {
            $event = $this->getDoctrine()->getRepository(Offre::class)->find($id);
            $event->setState($request->get('state'));//$content['locationEvent']
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return new Response('deleted to DataBase',200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }
    }



}
