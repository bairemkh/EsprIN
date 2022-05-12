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
}
