<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Util\Exception;
use Symfony\Component\Mime\Email;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User[]
     */
    public function sortByDateAsc(): array
    {
        $em=$this->getEntityManager();
       /* $res=$em->createQueryBuilder('user')
            ->orderBy('user.email', 'ASC')
            ->getQuery()
            ->getResult();*/
        //SELECT * FROM User u ORDER BY u.email ASC
       $res= $em->createQueryBuilder()
           ->select('u')
           ->from('App\Entity\User', 'u')
           ->orderBy('u.createdat ', 'ASC')
           ->getQuery();
        //$res=$em->createNativeQuery('SELECT * FROM User u ORDER BY u.email ASC', $this->createResultSetMappingBuilder("u"));

       return $res->getArrayResult();

    }

    /**
     * @return User[]
     */
    public function sortByDateDesc(): array
    {
        $em=$this->getEntityManager();
        /* $res=$em->createQueryBuilder('user')
             ->orderBy('user.email', 'ASC')
             ->getQuery()
             ->getResult();*/
        //SELECT * FROM User u ORDER BY u.email ASC
        $res= $em->createQueryBuilder()
            ->select('u')
            ->from('App\Entity\User', 'u')
            ->orderBy('u.createdat ', 'DESC')
            ->getQuery();
        //$res=$em->createNativeQuery('SELECT * FROM User u ORDER BY u.email ASC', $this->createResultSetMappingBuilder("u"));

        return $res->getArrayResult();

    }

    /**
     * @return User[]
     */
    public function showAdmins(): array
    {
        $em=$this->getEntityManager();
        $res= $em->createQueryBuilder()
            ->select('u')
            ->from('App\Entity\User', 'u')
            ->where('u.role=\'Admin\' ')
            ->getQuery();
        //$res=$em->createNativeQuery('SELECT * FROM User u ORDER BY u.email ASC', $this->createResultSetMappingBuilder("u"));

        return $res->getArrayResult();

    }

    /**
     * @return User[]
     */
    public function showStudents(): array
    {
        $em=$this->getEntityManager();
        $res= $em->createQueryBuilder()
            ->select('u')
            ->from('App\Entity\User', 'u')
            ->where('u.role=\'Etudiant\' ')
            ->getQuery();
        //$res=$em->createNativeQuery('SELECT * FROM User u ORDER BY u.email ASC', $this->createResultSetMappingBuilder("u"));

        return $res->getArrayResult();

    }

    /**
     * @return User[]
     */
    public function showClubs(): array
    {
        $em=$this->getEntityManager();
        $res= $em->createQueryBuilder()
            ->select('u')
            ->from('App\Entity\User', 'u')
            ->where('u.role=\'Club\' ')
            ->getQuery();
        //$res=$em->createNativeQuery('SELECT * FROM User u ORDER BY u.email ASC', $this->createResultSetMappingBuilder("u"));

        return $res->getArrayResult();

    }

    /**
     * @return User[]
     */
    public function showProfs(): array
    {
        $em=$this->getEntityManager();
        $res= $em->createQueryBuilder()
            ->select('u')
            ->from('App\Entity\User', 'u')
            ->where('u.role=\'Professeur\' ')
            ->getQuery();
        //$res=$em->createNativeQuery('SELECT * FROM User u ORDER BY u.email ASC', $this->createResultSetMappingBuilder("u"));

        return $res->getArrayResult();

    }

    /**
     * @return User[]
     */
    public function showExterns(): array
    {
        $em=$this->getEntityManager();
        $res= $em->createQueryBuilder()
            ->select('u')
            ->from('App\Entity\User', 'u')
            ->where('u.role=\'Extern\' ')
            ->getQuery();
        //$res=$em->createNativeQuery('SELECT * FROM User u ORDER BY u.email ASC', $this->createResultSetMappingBuilder("u"));

        return $res->getArrayResult();

    }

    public function test(): array
    {
        $em=$this->getEntityManager();

        $res =$em->createQueryBuilder()
            ->select('o.titleoffer,o.descoffer,o.catoffre,u.firstname as offre')
            ->from('App\Entity\Offre', 'o')
            ->innerJoin('App\Entity\User','u','with', "u.cinuser = o.offerprovider")
            ->getQuery();
        dump($res->getArrayResult());
        return $res->getArrayResult();

    }

    public function getStatistics(): array
    {
        $em=$this->getEntityManager();
        try {
            $numberProfs = $em->createQueryBuilder()
                ->select('u.role,count(u)')
                ->from('App\Entity\User', 'u')
                ->groupBy('u.role')
                ->getQuery()
                ->getArrayResult();
            return $numberProfs;
        } catch (Exception $e) {
            echo $e->getMessage();
        die;
        }


    }

}
