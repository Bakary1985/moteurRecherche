<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
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

    /**
    * @return Produit[] Returns an array of Produit objects
    */
  
    public function findSearchData(SearchData $searchData): array
    {

       
        $query = $this->createQueryBuilder('p')
            ->select('p','c')
            ->join('p.categories','c');

            if (!empty($searchData->q)) {
                $query = $query->andWhere('p.name LIKE :q')
                ->setParameter("q", "{$searchData->q}%");
            }

            if (!empty($searchData->min)) {
                $query = $query->andWhere('p.price >= :min')
                ->setParameter("min", $searchData->min);
            }

            if (!empty($searchData->max)) {
                $query = $query->andWhere('p.price <= :max')
                ->setParameter("max", $searchData->max);
            }

            if (!empty($searchData->promo)) {
                $query = $query->andWhere('p.promo = 1');
            }

            if (!empty($searchData->category)) {
                $query = $query->andWhere('c.id IN (:category)')
                ->setParameter("category", $searchData->category);
            }

        return $query->getQuery()->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
