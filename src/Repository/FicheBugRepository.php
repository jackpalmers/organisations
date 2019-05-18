<?php

namespace App\Repository;

use App\Entity\FicheBug;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FicheBug|null find($id, $lockMode = null, $lockVersion = null)
 * @method FicheBug|null findOneBy(array $criteria, array $orderBy = null)
 * @method FicheBug[]    findAll()
 * @method FicheBug[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FicheBugRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FicheBug::class);
    }

    // /**
    //  * @return FicheBugController[] On récupère un tableau de ficheBug pour chaque utilisateur
    //  */
    public function findFicheBugByUser($userId)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.userId = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('f.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
