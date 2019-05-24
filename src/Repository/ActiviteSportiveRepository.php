<?php

namespace App\Repository;

use App\Entity\ActiviteSportive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ActiviteSportive|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActiviteSportive|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActiviteSportive[]    findAll()
 * @method ActiviteSportive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActiviteSportiveRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ActiviteSportive::class);
    }

    // /**
    //  * @return ActiviteSportive[] On récupère un tableau d'activité sportive pour chaque utilisateur
    //  */
    public function findActiviteSportiveByUser($userId)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.userId = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }
}
