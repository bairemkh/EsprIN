<?php

namespace App\Repository;

use App\Entity\Alert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Alert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Alert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Alert[]    findAll()
 * @method Alert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Alert::class);
    }


    /**
     * @return Alert[] Returns an array of Articles objects
     */
    public function apiFindAll() : array
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a.idalert,a.alerttitle,a.content,a.destclass,a.createdat,c.idCatAlert AS catalert, c.cinuser AS idsender')
            ->innerJoin('App\Entity\User','u','with', "u.cinuser = a.idsender")
            ->innerJoin('App\Entity\Catalert','c','with','c.idCatAlert = a.catalert')
            ->orderBy('a.idalert', 'ASC');

        $query = $qb->getQuery();

        return $query->execute();
    }


    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Alert $entity, bool $flush = true): void
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
    public function remove(Alert $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

     /**
      * @return Alert[] Returns an array of Alert objects
      */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.state = :val')
            ->setParameter('val', $value)
            ->orderBy('a.idalert', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Alert
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
