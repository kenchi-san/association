<?php

namespace App\Repository;

use App\Entity\OurPartner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OurPartner|null find($id, $lockMode = null, $lockVersion = null)
 * @method OurPartner|null findOneBy(array $criteria, array $orderBy = null)
 * @method OurPartner[]    findAll()
 * @method OurPartner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OurPartnerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OurPartner::class);
    }

    // /**
    //  * @return OurPartner[] Returns an array of OurPartner objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OurPartner
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
