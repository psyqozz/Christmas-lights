<?php

namespace App\Repository;

use App\Entity\Light;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Light|null find($id, $lockMode = null, $lockVersion = null)
 * @method Light|null findOneBy(array $criteria, array $orderBy = null)
 * @method Light[]    findAll()
 * @method Light[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LightRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Light::class);
    }

    // /**
    //  * @return Light[] Returns an array of Light objects
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
    public function findOneBySomeField($value): ?Light
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
