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
            ->select('i, u')
            ->join('i.user', 'u')
            ->orderBy('i.created_at', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult()
        ;
    }

    public function instrusList() {
        return $this->createQueryBuilder('i')
            ->select('i, u')
            ->join('i.user', 'u')
            ->orderBy('i.created_at', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function filteredInstrusByKeyWord($value) {
        return $this->createQueryBuilder('i')
            ->select('i, u')
            ->join('i.user', 'u')
            ->orderBy('i.created_at', 'DESC')
            ->andWhere('i.title LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function filteredInstrusByGenre($value) {
        return $this->createQueryBuilder('i')
            ->select('i, u')
            ->join('i.user', 'u')
            ->orderBy('i.created_at', 'DESC')
            ->andWhere('i.genre LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function filteredInstrusByBoth($genre, $keyword) {
        return $this->createQueryBuilder('i')
            ->select('i, u')
            ->join('i.user', 'u')
            ->orderBy('i.created_at', 'DESC')
            ->where('i.genre LIKE :genre')
            ->andWhere('i.title LIKE :keyword')
            ->setParameters([ 'genre' => $genre, 'keyword' => $keyword])
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

    public function searchCount($value) {
        return $this->createQueryBuilder('i')
            ->select('count(i.id)')
            ->andWhere('i.title LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findOneByTitle($value): ?Instru
    {
        return $this->createQueryBuilder('i')
            ->select('i, t, to, u')
            ->join('i.textes', 't')
            ->join('i.toplines', 'to')
            ->join('i.user', 'u')
            ->andWhere('i.title = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneLatestUpload() {
        return $this->createQueryBuilder('i')
            ->select('i, u')
            ->join('i.user', 'u')
            ->orderBy('i.created_at', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findLatest()
    {
        return $this->createQueryBuilder('i')
            ->select('i, u')
            ->join('i.user', 'u')
            ->orderBy('i.created_at', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUserInstrus($user) {
        return $this->createQueryBuilder('i')
        ->select('i, u')
        ->join('i.user', 'u')
        ->setParameter('val', $user)
        ->where('i.user = :val')
        ->getQuery()
        ->getResult();
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
