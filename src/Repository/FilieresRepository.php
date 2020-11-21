<?php

namespace App\Repository;

use App\Entity\Filieres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Filieres|null find($id, $lockMode = null, $lockVersion = null)
 * @method Filieres|null findOneBy(array $criteria, array $orderBy = null)
 * @method Filieres[]    findAll()
 * @method Filieres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilieresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Filieres::class);
    }

    // /**
    //  * @return Filieres[] Returns an array of Filieres objects
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
    public function findOneBySomeField($value): ?Filieres
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
