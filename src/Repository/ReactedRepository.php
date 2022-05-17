<?php

namespace App\Repository;
use App\Entity\ReactedForum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReactedForum|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReactedForum|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReactedForum[]    findAll()
 * @method ReactedForum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class ReactedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReactedForum::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ReactedForum $entity, bool $flush = true): void
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
    public function remove(ReactedForum $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Like[] Returns an array of Like objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Like
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findreact($id,$cin): ?ReactedForum
    {
        return $this->createQueryBuilder('r')
            ->Where('r.idcreater = :cin')
            ->andWhere('r.idforum = :id')
            ->setParameter('cin', $cin)
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

}