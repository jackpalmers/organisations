<?php

namespace App\Repository;

use App\Entity\TacheAchat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TacheAchat|null find($id, $lockMode = null, $lockVersion = null)
 * @method TacheAchat|null findOneBy(array $criteria, array $orderBy = null)
 * @method TacheAchat[]    findAll()
 * @method TacheAchat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TacheAchatRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TacheAchat::class);
    }

    // /**
    //  * @return TacheAchat[] Returns an array of TacheAchat objects
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
    public function findOneBySomeField($value): ?TacheAchat
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
