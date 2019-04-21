<?php

namespace App\Repository;

use App\Entity\TacheRdv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TacheRdv|null find($id, $lockMode = null, $lockVersion = null)
 * @method TacheRdv|null findOneBy(array $criteria, array $orderBy = null)
 * @method TacheRdv[]    findAll()
 * @method TacheRdv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TacheRdvRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TacheRdv::class);
    }

    // /**
    //  * @return TacheRdv[] Returns an array of TacheRdv objects
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
    public function findOneBySomeField($value): ?TacheRdv
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
