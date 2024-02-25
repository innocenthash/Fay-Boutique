<?php

namespace App\Repository;

use App\ClassRecherche\Recherche;
use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 *
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

//    /**
//     * @return Produit[] Returns an array of Produit objects
//     */
public function findWithRecherche(Recherche $value): array
   {
       $query = $this->createQueryBuilder('p')
         ->select('c','p')
         ->join('p.Category','c') ;

if (!empty($value->categories)) {
    #-
 $query = $query->andWhere('c.id IN ( :categories)')->setParameter('categories', $value->categories) ;
}
       if (!empty($value->nom)) {
        $query = $query->andWhere('p.nom LIKE :nom')->setParameter('nom', "%{$value->nom}%") ;
       
       }    
           
           
return $query->getQuery()->getResult() ;
   }
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Produit
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
