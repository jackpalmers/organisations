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
    //  * @return TacheSport[] On récupère un tableau d'activité sportive pour chaque utilisateur
    //  */
    public function findActiviteSportiveByUser($userId)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.userId = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult()
            ;
    }
}
