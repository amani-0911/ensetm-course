<?php

namespace App\Repository;

use App\Entity\Articles;
use App\Entity\ArticleSearch;
use App\Entity\Filieres;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articles::class);
    }


      /**
      * @return Articles[] Returns an array of Articles objects
      */

    public function findbySearch(ArticleSearch $search)
    {
        $query=$this->findQeury();
        if($search->getModuleSearched()){
            $query=$query->andWhere('a.module = :module')
                ->setParameter('module',$search->getModuleSearched());

        }
        if($search->getSemestreSearched()){
            $query=$query->andWhere('a.semestre = :semestre')
                ->setParameter('semestre',$search->getSemestreSearched());
        }
        if($search->getFilieresSearched()){
                $query=$query->andWhere(":filieres MEMBER OF a.Filiers")
                    ->setParameter("filieres",$search->getFilieresSearched() );
            }


        return $query->getQuery()->getResult();

    }


    public function findArticlesFiliere(Filieres $filiere){
        $query=$this->findQeury();
        $query->andWhere(":filiere MEMBER OF a.Filiers")
            ->setParameter("filiere",$filiere);
        return $query->getQuery()->getResult();

    }



    private function findQeury():QueryBuilder
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.created_at','DESC');
    }


    /*
    public function findOneBySomeField($value): ?Articles
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
