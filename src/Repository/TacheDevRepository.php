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
    //  * @return TacheDev[] On récupère un tableau de tacheDev pour chaque utilisateur
    //  */
    public function findTacheDevByUser($userId)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.userId = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult()
        ;
    }
}
