<?php

namespace App\Repository;

use App\Entity\Texte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Texte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Texte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Texte[]    findAll()
 * @method Texte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TexteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Texte::class);
    }

    public function paginateAll($limit, $offset) {
        return $this->createQueryBuilder('t')
            ->orderBy('t.title', 'ASC')
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
    
    public function findLatest()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.created_at', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Texte[] Returns an array of Texte objects
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
    public function findOneBySomeField($value): ?Texte
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
