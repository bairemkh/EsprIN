<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Offre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offre[]    findAll()
 * @method Offre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offre::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Offre $entity, bool $flush = true): void
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
    public function remove(Offre $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

      /**
      * @return Offre[] Returns an array of Offre objects
      */

    public function findByStateField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.state = :val')
            ->setParameter('val', $value)
            ->orderBy('o.idoffer', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Offre
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    /**
     * @return Offre[]
     */
    public function sortByTitreAsc(): array
    {
        $em=$this->getEntityManager();

        $res =$em->createQueryBuilder()
            ->select('o.titleoffer,o.descoffer,o.catoffre,u.firstname,o.state')
            ->from('App\Entity\Offre', 'o')
            ->innerJoin('App\Entity\User','u','with', "u.cinuser = o.offerprovider")
            ->orderBy('o.titleoffer','ASC')
            ->getQuery();
        dump($res->getArrayResult());
        return $res->getArrayResult();

    }


}
