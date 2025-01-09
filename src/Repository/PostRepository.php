<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Collection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function searchPosts(
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
            $qb->andWhere('d.salary BETWEEN :minimumSalary AND :maximumSalary')
               ->setParameter('minimumSalary', $minimumSalary)
               ->setParameter('maximumSalary', $maximumSalary);
        } elseif ($minimumSalary !== null) {
            $qb->andWhere('d.salary >= :minimumSalary')
               ->setParameter('minimumSalary', $minimumSalary);
        } elseif ($maximumSalary !== null) {
            $qb->andWhere('d.salary <= :maximumSalary')
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
            $orX->add('d.experience <= :experience');
            $qb->setParameter('experience', $experience);
        }
    
        // Ajout des critères OR à la requête
        if ($orX->count() > 0) {
            $qb->orWhere($orX);
        }
        
        //dd($qb->getQuery());
        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Post[] Returns an array of Post objects
    //     */
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

    //    public function findOneBySomeField($value): ?Post
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
