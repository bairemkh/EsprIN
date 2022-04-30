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
     * @return Event[]
     */
    public function sortByDateAsc(): array
    {
        $em=$this->getEntityManager();
        $query= $em->createQueryBuilder()
            ->select('e')
            ->from('App\Entity\Event', 'e')
            ->orderBy('e.datedebut ', 'ASC')
            ->getQuery();

        return $query->getArrayResult();
    }


    /**
     * @return Event[]
     */
    public function sortByDateDesc(): array
    {
        $em=$this->getEntityManager();
        $query= $em->createQueryBuilder()
            ->select('e')
            ->from('App\Entity\Event', 'e')
            ->orderBy('e.datedebut ', 'DESC')
            ->getQuery();

        return $query->getArrayResult();
    }


    /**
     * @return Event[]
     */
    /*public function showBySysDate(): array
    {
        $em=$this->getEntityManager();
        $query= $em->createQueryBuilder()
            ->select('e')
            ->from('App\Entity\Event', 'e')
            ->where('e.datedebut= ')
            ->getQuery();

        return $query->getArrayResult();
    }*/


    /**
     * @return Event[]
     */
   /* public function showByParticipate(): array
    {
        $em=$this->getEntityManager();
        $query= $em->createQueryBuilder()
            ->select('e')
            ->from('App\Entity\Event', 'e')
            ->where('e.cinuser=1010101')
            ->getQuery();

        return $query->getArrayResult();
    }*/



    /**
     * @return Event[]
     */

  /*  public function findByParticipate($cin): ?User
    {
        $em= $this->getEntityManager();
        $query = $em -> createQuery('SELECT * FROM `participate` where `cinUser` == :cin')
            ->setParameter('cin', $cin);

        return $query->getArrayResult();
    }
*/
    public function findByParticipate(): array
    {
        $em=$this->getEntityManager();

        $res =$em->createQueryBuilder()
            ->select('e')
            ->from('App\Entity\Participate', 'p')
            ->innerJoin('App\Entity\Event','e','with', "p.event = e.idevent")
            ->innerJoin('App\Entity\User','u','with', "u.cinuser = p.participent")
            ->where('u.cinuser = 1010101')
            ->getQuery();
        dump($res->getArrayResult());
        return $res->getArrayResult();

    }



    public function findById($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }


    public function findByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e 
                FROM Event e
                WHERE e.title LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();

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
