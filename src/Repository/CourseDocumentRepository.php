<?php

namespace App\Repository;

use App\Entity\CourseDocument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CourseDocument|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourseDocument|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourseDocument[]    findAll()
 * @method CourseDocument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseDocumentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CourseDocument::class);
    }

    // /**
    //  * @return CourseDocument[] Returns an array of CourseDocument objects
    //  */

    public function findLastDocument($maxResult)
    {
        return $this->createQueryBuilder('document')
            ->setMaxResults($maxResult)
            ->getQuery()
            ->getResult();
    }

    public function findDocumentByUser($user)
    {
        return $this->createQueryBuilder('document')
            ->innerJoin('document.course', 'courseDocument')
            ->innerJoin('courseDocument.courseCategory', 'categoryName', 'WITH', 'categoryName.name != :name')
            ->setParameter('name', 'null')
            ->andWhere('document.author = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?CourseDocument
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
