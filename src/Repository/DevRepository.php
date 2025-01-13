<?php

namespace App\Repository;

use App\Entity\Dev;
use App\Entity\Techno;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dev>
 */
class DevRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dev::class);
    }

    public function searchDevs(
        ?int $minimumSalary,
        ?int $maximumSalary,
        ?string $city,
        ?Collection $technos,
        ?int $experience
    ): array {
        $qb = $this->createQueryBuilder('d');
    
        $orX = $qb->expr()->orX();
    
        // Gestion du salaire (intervalle entre minimumSalary et maximumSalary)
        if ($minimumSalary !== null && $maximumSalary !== null) {
            $qb->andWhere('d.minimumSalay BETWEEN :minimumSalary AND :maximumSalary')
               ->setParameter('minimumSalary', $minimumSalary)
               ->setParameter('maximumSalary', $maximumSalary);
        } elseif ($minimumSalary !== null) {
            $qb->andWhere('d.minimumSalay >= :minimumSalary')
               ->setParameter('minimumSalary', $minimumSalary);
        } elseif ($maximumSalary !== null) {
            $qb->andWhere('d.minimumSalay <= :maximumSalary')
               ->setParameter('maximumSalary', $maximumSalary);
        }
    
        // Gestion de la ville avec OR
        if ($city !== null) {
            $orX->add('d.city = :city');
            $qb->setParameter('city', $city);
        }
    
        // Gestion des technologies avec OR
        if (!empty($technos)) {
            $orX->add($qb->expr()->in('t.id', ':technos'));
            $qb->leftJoin('d.technos', 't')
               ->setParameter('technos', $technos);
        }
    
        // Gestion de l'expérience avec OR
        if ($experience !== null) {
            $orX->add('d.experience >= :experience');
            $qb->setParameter('experience', $experience);
        }
    
        // Ajout des critères OR à la requête
        if ($orX->count() > 0) {
            $qb->orWhere($orX);
        }
        
        //dd($qb->getQuery());
        return $qb->getQuery()->getResult();
    }

    public function findAllOrderByCountViewDsc(): array
    {
        return $this->createQueryBuilder('d')
            ->orderBy('d.countView', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findLastThreeDevs(): array
    {
        return $this->createQueryBuilder('d')
            ->orderBy('d.id', 'DESC') // Tri par date de création en décroissant
            ->setMaxResults(3)              // Limiter à 3 résultats
            ->getQuery()
            ->getResult();
    }
    
    /**
     * Recherche des développeurs en fonction des critères
     * 
     * @param array $filters
     * @return Dev[]
     */
    public function findByFilters(array $filters): array
    {
        $qb = $this->createQueryBuilder('d');

        if (!empty($filters['experience'])) {
            $qb->andWhere('d.experience >= :experience')
               ->setParameter('experience', $filters['experience']);
        }

        if (!empty($filters['minimumSalay'])) {
            $qb->andWhere('d.minimumSalay <= :minimumSalay')
               ->setParameter('minimumSalay', $filters['minimumSalay']);
        }

        if (!empty($filters['city'])) {
            $qb->andWhere('d.city LIKE :city')
               ->setParameter('city', '%' . $filters['city'] . '%');
        }

        if (!empty($filters['technos'])) {
            $qb->join('d.technos', 't')
               ->andWhere('t.id IN (:technos)')
               ->setParameter('technos', $filters['technos']);
        }

        return $qb->getQuery()->getResult();
    }




    //    /**
    //     * @return Dev[] Returns an array of Dev objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Dev
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
