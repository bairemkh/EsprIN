<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\User;
use App\Form\InterestType;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManager;
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
            ->findAll();
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
     * @Route("/navbar-v2-offres", name="navbar-v2-offres")
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

        return $this->render('FrontOffice/navbar-v2-offres.html.twig',['offres'=>$offres]);
    }

    /**
     * @Route("/deleteOffer/{id}", name="deleteOffer")
     */
    public function deleteOffer(Offre $offre): Response
    {
        $em=$this->getDoctrine()->getManager();
        /*$offer = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->find($id);
        $offer->setState("Deleted");
        $em->flush();*/
        $em->remove($offre);
        $em->flush();
       return $this->redirectToRoute('navbar-v2-offres');

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
    public function addOffer(Request $request): Response
    {
        $offre = new Offre();
        $form = $this->createForm(OffreType::class,$offre);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($offre);
            $em->flush();
            return $this->redirectToRoute('navbar-v2-offres');
        }

        return $this->render('FrontOffice/addOffre.html.twig',['f'=>$form->createView()]);

    }

    /**
     * @Route("/updateOffer/{id}", name="updateOffer")
     */
    public function updateOffer(Request $request, $id): Response
    {
        $offre = $this->getDoctrine()->getManager()->getRepository(Offre::class)->find($id);
        $form = $this->createForm(OffreType::class,$offre);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('navbar-v2-offres');
        }

        return $this->render('FrontOffice/updateOffre.html.twig',['f'=>$form->createView()]);

    }


    ////////


    /**
     * @Route ("/navbar-v2-offres/Intrest/{id}",name="addIntrest")
     */
    public function addIntrest(Request $request , $id):Response
    {
        dump($request);
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find(10000000);

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

        return $this->redirectToRoute('navbar-v2-offres');
    }

    /**
     * @Route ("/navbar-v2-offres/deleteIntrest/{id}",name="deleteIntrest")
     */
    public function deleteIntrest($id)
    {
        $em=$this->getDoctrine()->getManager();
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find(1010101);

        $offre = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->find($id);
        $offre->removeCinintrested($user);
        $em=$this->getDoctrine()->getManager();
        $em->flush();
        $this->addFlash(
            'info',
            'Intrest Deleted Successfully'
        );
        return $this->redirectToRoute('navbar-v2-offres');
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
        $Alternance = $offreRepository->createQueryBuilder('o')
            ->select('count(o.idoffer)')
            ->Where('o.catoffre= :catoffre')
            ->setParameter('catoffre', "Alternance")
            ->getQuery()
            ->getSingleScalarResult();

        //$state="Active";
        //$Stage="Stage";

        $Stage = $offreRepository->createQueryBuilder('o')
            ->select('count(o.idoffer)')
            ->Where('o.catoffre= :catoffre')
            //->andWhere('o.state= :Active')
            ->setParameter('catoffre', "Stage")
            //->setParameters(array('o.catoffre'=>$Stage,'o.state'=>$state))

            ->getQuery()
            ->getSingleScalarResult();

        $Offre_de_travail = $offreRepository->createQueryBuilder('o')
            ->select('count(o.idoffer)')
            ->Where('o.catoffre= :catoffre')
            ->setParameter('catoffre', "Offre de travail")
            ->getQuery()
            ->getSingleScalarResult();


        return $this->render('BackOffice/stats.html.twig', [
            'nAlternance' => $Alternance,
            'nStage' => $Stage,
            'nOffre_de_travail' => $Offre_de_travail,
        ]);

    }


    //Api

    /**
     * @Route("/api/offreList", name="offreList", methods={"GET"})
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
     * @Route("/api/rechercheOffreIdTitleCat/{id}/{title}/{category}", name="rechercheOffreIdTitleCat", methods={"GET"})
     */
    public function rechercheOffreIdTitleCat($id, $title, $category, SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $offres=$em->createQueryBuilder()
            ->select('o.idoffer,o.titleoffer,o.descoffer,o.catoffre,u.cinuser AS offerprovider')
            ->from('App\Entity\Offre','o')
            ->innerJoin('App\Entity\User','u','with', "u.cinuser = o.offerprovider")
            ->where('o.idoffer=:id')
            ->andWhere('o.titleoffer=:title')
            ->andWhere('o.catoffre=:category')
            ->setParameters(array('id'=>$id,'title'=>$title,'category'=>$category))
            ->getQuery()
            ->getArrayResult();
        $json = $serializer->serialize($offres, 'json', ['groups' => '$offres']);
        $Response = new Response($json);
        return $Response;
    }

    /**
     * @Route("/api/addOfferAPI", name="addOfferApi")
     */
    public function addOfferApi(Request $request, SerializerInterface $serializer)
    {
        try {

            $content=$request->getContent();
            $offres=json_decode($content,true);
            $offre = New Offre();
            $offre->setTitleoffer($offres['titleoffer']);
            $offre->setDescoffer($offres['descoffer']);
            $offre->setCatoffre($offres['catoffre']);
            $user=$this->getDoctrine()->getRepository(User::class)->findOneBy(['cinuser'=>$offres['offerprovider']]);
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
     * @Route("/api/updateOfferAPI/{id}", name="updateOfferAPI")
     */
    public function updateOfferAPI(Offre $offre, Request $request, $id)
    {
        try {

            $content=$request->getContent();
            $offres=json_decode($content,true);
            $offre = $this->getDoctrine()->getManager()->getRepository(Offre::class)->find($id);
            $offre->setTitleoffer($offres['titleoffer']);
            $offre->setDescoffer($offres['descoffer']);
            $offre->setCatoffre($offres['catoffre']);
            $user=$this->getDoctrine()->getRepository(User::class)->findOneBy(['cinuser'=>$offres['offerprovider']]);
            $offre->setOfferprovider($user);
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return new Response('update to DataBase',200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }
    }



    /**
     * @Route("/api/deleteOfferApi/{id}", name="deleteOfferApi")
     */
    public function deleteOfferApi(Offre $offre, Request $request, $id)
    {
        try {

            $content=$request->getContent();
            $offres=json_decode($content,true);
            $offre = $this->getDoctrine()->getManager()->getRepository(Offre::class)->find($id);
            $offre->setState('Deleted');
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return new Response('Deleted',200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }
    }

}
