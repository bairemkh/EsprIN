<?php

namespace App\Controller;

use Dompdf\Exception;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class MailController extends AbstractController
{

    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendMailToExtern($to, $name, $passwd)
    {

        $html = $this->renderView('mail/TemplateMail.html.twig', ['email' => $to,
            'password' => $passwd,
            'name'=>$name
            ]);
        $email=(new TemplatedEmail())
            ->from('khedhribairem@gmail.com')
            ->to($to)
            ->subject('Welcome to EsprIN')
            ->htmlTemplate('mail/TemplateMail.html.twig')

            ->html($html);
        $transport=Transport::fromDsn($_ENV['MAILER_DSN']);
        $mailer=new Mailer($transport);
        $mailer->send($email);
    }
    /**
     * @Route("/api/sendmail", name="loginCheckapi")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendMailToExternApi(Request $request):Response
    {
        try {
            $html = $this->renderView('mail/TemplateMail.html.twig', ['email' => $request->get('to'),
                'password' => $request->get('passwd'),
                'name'=>$request->get('name')
            ]);
            $email=(new TemplatedEmail())
                ->from('khedhribairem@gmail.com')
                ->to($request->get('to'))
                ->subject('Welcome to EsprIN')
                ->htmlTemplate('mail/TemplateMail.html.twig')

                ->html($html);
            $transport=Transport::fromDsn($_ENV['MAILER_DSN']);
            $mailer=new Mailer($transport);
            $mailer->send($email);
            return new Response("Mail sent",200);
        }catch (Exception $exception){
            return new Response($exception->getMessage(),500);
        }
    }
}
