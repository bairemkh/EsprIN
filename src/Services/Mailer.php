<?php

namespace App\Services;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Transport;

class Mailer
{
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
        $mailer=new \Symfony\Component\Mailer\Mailer($transport);
        $mailer->send($email);
        return new Response('mail sent with sucess');
    }
}