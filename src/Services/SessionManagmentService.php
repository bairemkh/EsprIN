<?php

namespace App\Services;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class SessionManagmentService
{
    private SessionInterface $currentSession;
    public function __construct(SessionInterface $session)
    {
        $this->currentSession=$session;
    }


    public function createSession(User $user)
    {
        $session = new Session(new NativeSessionStorage(), new AttributeBag());
        $session->set('User', $user);
        $session->start();
    }

    public function deleteCurrentSession()
    {
        $this->currentSession->invalidate();
    }

    public function verifySessionOpened():bool
    {
        return !empty($this->currentSession->all());

    }

    public function getData():array
    {
        return $this->currentSession->all();
    }
    public function getUser():object
    {

        return $this->currentSession->get('User');
    }


}