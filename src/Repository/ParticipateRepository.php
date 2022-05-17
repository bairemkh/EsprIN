<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\Participate;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use http\Env\Response;

/**
 * @extends ServiceEntityRepository<Participate>
 *
 * @method Participate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participate[]    findAll()
 * @method Participate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participate::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Participate $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Participate $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Participate[] Returns an array of Participate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Participate
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function userReacted($currentUser,$id):bool{
        $event=$this->getEntityManager()
            ->getRepository(Event::class)
            ->find($id);
        $participate = $this->getEntityManager()
            ->getRepository(Participate::class)
            ->findOneBy(['participent'=>$currentUser,'event'=>$event]);
        dump($participate);
        return $participate!=null;
    }

    public function addParticipate($currentUser,$id):int{
        $user = $this->getEntityManager()
            ->getRepository(User::class)
            ->find($currentUser->getCinuser());


        $event = $this->getEntityManager()
            ->getRepository(Event::class)
            ->find($id);
        $event->addCinuser($user);
        $em = $this->getEntityManager();
        $em->flush();
        return $event->getNbrparticipant()+1;
    }
    public function deleteParticipate($currentUser,$id):int{
        $user = $this->getEntityManager()
            ->getRepository(User::class)
            ->find($currentUser->getCinuser());
        $event = $this->getEntityManager()
            ->getRepository(Event::class)
            ->find($id);
        $event->removeCinuser($user);
        $em = $this->getEntityManager();
        $em->flush();
        return $event->getNbrparticipant()-1;
    }


}
