<?php

namespace App\Repository;

use App\Entity\TacheSport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TacheSport|null find($id, $lockMode = null, $lockVersion = null)
 * @method TacheSport|null findOneBy(array $criteria, array $orderBy = null)
 * @method TacheSport[]    findAll()
 * @method TacheSport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TacheSportRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TacheSport::class);
    }

    // /**
    //  * @return TacheSport[] Returns an array of TacheSport objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TacheSport
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
