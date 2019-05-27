<?php

namespace App\Repository;

use App\Entity\FicheBug;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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
            ->orderBy('f.numFiche', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return FicheBugController[] On récupère la dernière fiche de bug créée par l'utilisateur
    //  */
    public function findLastFicheBugByUser($userId)
    {
        try
        {
            return $this->createQueryBuilder('f')
                ->andWhere('f.userId = :userId')
                ->setParameter('userId', $userId)
                ->setMaxResults('1')
                ->orderBy('f.numFiche', 'DESC')
                ->getQuery()
                ->getSingleResult();
        }
        catch (NoResultException $e)
        {
        }
        catch (NonUniqueResultException $e)
        {
        }
    }

    // /**
    //  * @return FicheBugController[] On récupère les 3 derniers bug en cours
    //  */
    public function findFicheBugEnCoursByUser($userId)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.userId = :userId')
            ->andWhere('f.Etat = 0')
            ->setParameter('userId', $userId)
            ->setMaxResults('3')
            ->orderBy('f.numFiche', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
