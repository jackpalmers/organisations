<?php

namespace App\Repository;

use App\Entity\TacheDev;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TacheDev|null find($id, $lockMode = null, $lockVersion = null)
 * @method TacheDev|null findOneBy(array $criteria, array $orderBy = null)
 * @method TacheDev[]    findAll()
 * @method TacheDev[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TacheDevRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TacheDev::class);
    }

    // /**
    //  * @return TacheDev[] Returns an array of TacheDev objects
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
    public function findOneBySomeField($value): ?TacheDev
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
