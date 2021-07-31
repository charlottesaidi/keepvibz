<?php

namespace App\Repository;

use App\Entity\Topline;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Topline|null find($id, $lockMode = null, $lockVersion = null)
 * @method Topline|null findOneBy(array $criteria, array $orderBy = null)
 * @method Topline[]    findAll()
 * @method Topline[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ToplineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Topline::class);
    }

    public function paginateAll($limit, $offset) {
        return $this->createQueryBuilder('t')
            ->orderBy('t.created_at', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult()
        ;
    }

    public function paginateCount() {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findUserToplines($user) {
        return $this->createQueryBuilder('t')
        ->join('t.user', 'u')
        ->setParameter('val', $user)
        ->where('t.user = :val')
        ->getQuery()
        ->getResult();
    }

    public function findInstruToplines($instru) {
        return $this->createQueryBuilder('t')
        ->join('t.instru', 'u')
        ->setParameter('val', $instru)
        ->where('t.user = :val')
        ->getQuery()
        ->getResult();
    }

    // /**
    //  * @return Topline[] Returns an array of Topline objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Topline
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
