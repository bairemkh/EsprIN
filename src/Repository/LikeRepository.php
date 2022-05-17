<?php

namespace App\Repository;

use App\Entity\Forum;
use App\Entity\Like;
use App\Entity\Post;
use App\Entity\ReactedForum;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Like|null find($id, $lockMode = null, $lockVersion = null)
 * @method Like|null findOneBy(array $criteria, array $orderBy = null)
 * @method Like[]    findAll()
 * @method Like[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Like::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Like $entity, bool $flush = true): void
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
    public function remove(Like $entity, bool $flush = true): void
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
    public function findlike($id,$cin): ?Like
    {
        return $this->createQueryBuilder('l')
            ->Where('l.likeuser = :cin')
            ->andWhere('l.likepost = :id')
            ->setParameter('cin', $cin)
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function addLike($currentUser, $id): int
    {
        $user = $this->getEntityManager()
            ->getRepository(User::class)
            ->find($currentUser->getCinuser());

        $post = $this->getEntityManager()
            ->getRepository(Post::class)
            ->find($id);
        $like=new Like();
        $like->setLikeuser($user->getCinuser());
        $like->setLikepost($id);
        $em = $this->getEntityManager();
        $em->persist($like);
        $em->flush();
        return $post->getLikenum() + 1;
    }

    public function deleteLike($currentUser, $id): int
    {
        $post = $this->getEntityManager()
            ->getRepository(Post::class)
            ->find($id);
        $like=$this->findlike($id,$currentUser->getCinuser());
        $em = $this->getEntityManager();
        $em->remove($like);
        $em->flush();
        return $post->getLikenum();
    }

}
