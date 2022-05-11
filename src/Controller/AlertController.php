<?php

namespace App\Controller;

use App\Entity\Alert;
use App\Repository\AlertRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/GeneratePdfAlert", name="GeneratePdfAlert")
     */
    public function getListPDF(AlertRepository $alertRepository):Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        $alerts = $alertRepository->findAll();

        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('FrontOffice/alertPDF.html.twig',['alerts'=>$alerts]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("AlertsList.pdf", [
            "Attachment" => true
        ]);

        exit(0);
    }





}
