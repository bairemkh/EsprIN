<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Event $entity, bool $flush = true): void
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
    public function remove(Event $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

     /**
     * @return Event[] Returns an array of Event objects
      */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.state = :val')
            ->setParameter('val', $value)
            ->orderBy('e.idevent', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }



    /**
     * @return Event[] Returns an array of Event objects
     */

     public function addParticipate($idevent): ?User
      {
      }


    /**
     * @return Event[] Returns an array of Event objects
     */

    public function findByIdEvent($id): ?User
    {
        $em= $this->getEntityManager();
        $query = $em -> createQuery('SELECT * FROM `participate` where 	`idEvent` == :id')
            ->setParameter('id', $id);

        return $query->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
