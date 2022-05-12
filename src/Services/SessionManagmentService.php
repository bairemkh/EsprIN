<?php

namespace App\Services;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class SessionManagmentService
{
    private SessionInterface $currentSession;
    private EntityManagerInterface $em;
    public function __construct(SessionInterface $session,EntityManagerInterface $entityManager)
    {
        $this->currentSession=$session;
        $this->em=$entityManager;
    }


    public function createSession(User $user)
    {
        $connect=$this->em->getRepository(User::class)->findOneBy(['cinuser'=>$user->getCinuser()]);
        $connect->setState('Connected');
        $this->em->persist($connect);
        $this->em->persist($connect);
        $session = new Session(new NativeSessionStorage(), new AttributeBag());
        $session->set('User', $user);
        $session->start();
    }

    public function deleteCurrentSession()
    {
        $connect=$this->em->getRepository(User::class)->findOneBy(['cinuser'=>$this->getUser()->getCinuser()]);
        $connect->setState('Disconnected');
        $this->em->persist($connect);
        $this->em->persist($connect);
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