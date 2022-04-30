<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/mail", name="sendMail")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendMail(): Response
    {
        $html = $this->renderView('mail/TemplateMail.html.twig', ['email' => 'bairemkh@gmail.com',
            'password' => 'bairem1111',
            'name'=>'Bairem khedhri'
            ]);
        $email=(new TemplatedEmail())
            ->from('khedhribairem@gmail.com')
            ->to('bairemkh@gmail.com')
            ->subject('Welcome to EsprIN')
            ->htmlTemplate('mail/TemplateMail.html.twig')

            ->html($html);
        $transport=Transport::fromDsn($_ENV['MAILER_DSN']);
        $mailer=new Mailer($transport);
        $mailer->send($email);
        return new Response('mail sent with sucess');
    }
}
