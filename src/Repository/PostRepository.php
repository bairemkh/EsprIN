<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;



/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Post $entity, bool $flush = true): void
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
    public function remove(Post $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    public function findByState($state){

        return $this->createQueryBuilder('p')
            ->Where('p.state = :val')
            ->setParameter('val', $state)
            ->orderBy('p.idpost', 'ASC')

            ->getQuery()
            ->getResult()
            ;


    }


    /**
     * @return Post[]
     */
    public function sortByDateAsc(): array
    {
        $em=$this->getEntityManager();

        $res= $em->createQueryBuilder()
            ->select('p')
            ->from('App\Entity\Post', 'p')
            ->orderBy('p.createdat ', 'ASC')
            ->getQuery();

        return $res->getArrayResult();

    }

    /**
     * @return Post[]
     */
    public function sortByDateDesc(): array
    {
        $em = $this->getEntityManager();
        $res = $em->createQueryBuilder()
            ->select('p')
            ->from('App\Entity\Post', 'p')
            ->orderBy('p.createdat ', 'DESC')
            ->getQuery();

        return $res->getArrayResult();


    }
    public function findEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e
                FROM App:Post p
                WHERE p.content LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
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
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
