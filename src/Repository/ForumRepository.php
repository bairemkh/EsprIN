<?php

namespace App\Repository;

use App\Entity\Forum;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Forum|null find($id, $lockMode = null, $lockVersion = null)
 * @method Forum|null findOneBy(array $criteria, array $orderBy = null)
 * @method Forum[]    findAll()
 * @method Forum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Forum::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Forum $entity, bool $flush = true): void
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
    public function remove(Forum $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findBytitle($title,$tag)
    {
        if($title != "" && $tag!=""){
            return $this->createQueryBuilder('f')
                ->andWhere('f.title = :val')
                ->setParameter('val', $title)
                ->andWhere('f.categorieforum = :tag')
                ->setParameter('tag', $tag)
                ->orderBy('f.idforum', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult();
        } else if($title!=""){
            return $this->createQueryBuilder('f')
                ->andWhere('f.title = :val')
                ->setParameter('val', $title)
                ->orderBy('f.idforum', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult();
        } else if($tag!=""){
            return $this->createQueryBuilder('f')
                ->andWhere('f.categorieforum = :tag')
                ->setParameter('tag', $tag)
                ->orderBy('f.idforum', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult();
        }

    }

    public function findBytag($tag)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.categorieforum = :val')
            ->setParameter('val', $tag)
            ->orderBy('f.idforum', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Forum[] Returns an array of Forum objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Forum
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @return Forum[]
     */
    public function sortByDateAsc($tag): array
    {
        $em=$this->getEntityManager();

        $res= $em->createQueryBuilder()
            ->select('p')
            ->from('App\Entity\Forum', 'p')
            ->where('p.state = :val')
            ->setParameter('val', $tag)
            ->orderBy('p.datecreation ', 'ASC')
            ->getQuery();

        return $res->getArrayResult();

    }

    /**
     * @return Forum[]
     */
    public function sortByDateDesc($tag): array
    {
        $em = $this->getEntityManager();
        $res = $em->createQueryBuilder()
            ->select('p')
            ->where('p.state = :val')
            ->setParameter('val', $tag)
            ->from('App\Entity\Forum', 'p')
            ->orderBy('p.datecreation ', 'DESC')
            ->getQuery();

        return $res->getArrayResult();


    }
}
