<?php

namespace App\Repository;

use App\Entity\IntroductionSchool;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IntroductionSchool|null find($id, $lockMode = null, $lockVersion = null)
 * @method IntroductionSchool|null findOneBy(array $criteria, array $orderBy = null)
 * @method IntroductionSchool[]    findAll()
 * @method IntroductionSchool[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntroductionSchoolRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IntroductionSchool::class);
    }

    // /**
    //  * @return AdminIntroductionSchoolController[] Returns an array of AdminIntroductionSchoolController objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdminIntroductionSchoolController
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
