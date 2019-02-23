<?php

namespace App\Repository;

use App\Entity\LabelCourse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LabelCourse|null find($id, $lockMode = null, $lockVersion = null)
 * @method LabelCourse|null findOneBy(array $criteria, array $orderBy = null)
 * @method LabelCourse[]    findAll()
 * @method LabelCourse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LabelCourseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LabelCourse::class);
    }

    // /**
    //  * @return LabelCourse[] Returns an array of LabelCourse objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LabelCourse
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
