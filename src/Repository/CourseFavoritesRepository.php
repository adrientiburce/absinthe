<?php

namespace App\Repository;

use App\Entity\CourseFavorites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CourseFavorites|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourseFavorites|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourseFavorites[]    findAll()
 * @method CourseFavorites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseFavoritesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CourseFavorites::class);
    }

    // /**
    //  * @return CourseFavorites[] Returns an array of CourseFavorites objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CourseFavorites
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
