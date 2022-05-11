<?php

namespace App\Repository;

use App\Entity\Annoncement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annoncement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annoncement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annoncement[]    findAll()
 * @method Annoncement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnoncementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annoncement::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Annoncement $entity, bool $flush = true): void
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
    public function remove(Annoncement $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Annoncement[] Returns an array of Annoncement objects
     */

    public function findByStateField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.state = :val')
            ->setParameter('val', $value)
            ->orderBy('a.idann', 'ASC')
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Annoncement
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findBytitle($title, $dest)
    {
        if ($title != "" && $dest != "") {
            return $this->createQueryBuilder('a')
                ->andWhere('a.subject = :val')
                ->setParameter('val', $title)
                ->andWhere('a.destination = :dest')
                ->setParameter('dest', $dest)
                ->orderBy('a.idann', 'ASC')
                ->getQuery()
                ->getResult();
        } else if ($title != "") {
            return $this->createQueryBuilder('a')
                ->andWhere('a.subject = :val')
                ->setParameter('val', $title)
                ->orderBy('a.idann', 'ASC')
                ->getQuery()
                ->getResult();
        } else if ($dest != "") {
            return $this->createQueryBuilder('a')
                ->andWhere('a.destination = :dest')
                ->setParameter('tag', $dest)
                ->orderBy('a.idann', 'ASC')
                ->getQuery()
                ->getResult();
        }

    }
}
