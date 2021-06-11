<?php

namespace App\Repository;

use App\Entity\Instru;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Instru|null find($id, $lockMode = null, $lockVersion = null)
 * @method Instru|null findOneBy(array $criteria, array $orderBy = null)
 * @method Instru[]    findAll()
 * @method Instru[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstruRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Instru::class);
    }

    public function paginateAll($limit, $offset) {
        return $this->createQueryBuilder('i')
            ->orderBy('i.title', 'ASC')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult()
        ;
    }

    public function paginateCount() {
        return $this->createQueryBuilder('i')
            ->select('count(i.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findOneByTitle($value): ?Instru
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.title = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    public function findLatest()
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.created_at', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Instru[] Returns an array of Instru objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Instru
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
