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
            ->orderBy('t.title', 'DESC')
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
            ->orderBy('t.created_at', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUserTextes($user) {
        return $this->createQueryBuilder('t')
        ->join('t.user', 'u')
        ->setParameter('val', $user)
        ->where('t.user = :val')
        ->getQuery()
        ->getResult();
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
