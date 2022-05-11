<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\User;
use App\Services\SessionManagmentService;
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
    private SessionManagmentService $session;
    public function __construct(ManagerRegistry $registry,SessionManagmentService $session)
    {
        $this->session=$session;
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

   /*  public function addParticipate($idevent): ?User
      {
      }*/


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

    public function findByParticipate(): array
    {
        $em=$this->getEntityManager();
        $id=$this->session->getUser()->getCinuser();

        $res =$em->createQueryBuilder()
            ->select('e')
            ->from('App\Entity\Participate', 'p')
            ->innerJoin('App\Entity\Event','e','with', "p.event = e.idevent")
            ->innerJoin('App\Entity\User','u','with', "u.cinuser = p.participent")
            ->where('u.cinuser = '.$id)
            ->getQuery()
            ->getArrayResult();

        dump($res);
        return $res;

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



}
