<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function findAll()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC')
        ;
    }

    public function findCoursesWithCategory()
    {
        return $this->createQueryBuilder('course')
            ->innerJoin('course.courseCategory', 'categoryName', 'WITH', 'categoryName.name != :name')
            ->setParameter('name', 'null')
            ->orderBy('course.name', 'ASC')  
        ;
    }

    public function findCoursesWithSlug($slug)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.courseCategory', 'category')
            ->andWhere('category.slug = :slug')
            ->setParameter('slug', $slug)
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return Course[] Returns an array of Course objects
    //  */

    public function findCoursesLikedByUser($userId)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.courseFavorites', 'favorites')
            ->andWhere('favorites.user = :user')
            ->setParameter('user', $userId)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Course
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
