<?php

namespace App\Repository;

use App\Entity\TacheRdv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\User;

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

     /**
      * @return TacheRdv[] On récupère un tableau de tacheRdv pour chaque utilisateur où la date du rdv est supérieur à la date actuelle (Rdv à venir)
      */
    public function findTacheRdvAVenirOrderByDateDesc($dateNow, $userId)
    {
        return $this->createQueryBuilder('t')
            ->AndWhere('t.date >= :dateNow')
            ->AndWhere('t.userId = :userId')
            ->orderBy('t.date', 'DESC')
            ->setParameter('dateNow', $dateNow)
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return TacheRdv[] On récupère un tableau de tacheRdv pour chaque utilisateur où la date du rdv est inférieur à la date actuelle (Rdv passé)
     */
    public function findTacheRdvPasseOrderByDateDesc($dateNow, $userId)
    {
        return $this->createQueryBuilder('t')
            ->AndWhere('t.date <= :dateNow')
            ->AndWhere('t.userId = :userId')
            ->orderBy('t.date', 'Desc')
            ->setParameter('dateNow', $dateNow)
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

//     /**
//      * @return TacheRdv[] Returns an array of TacheRdv objects
//      */
//    public function findTacheRdvOrderByDateCreation($value)
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.id = :id')
//            ->setParameter('id', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(3)
//            ->getQuery()
//            ->getResult()
//            ;
//    }
//    public function findByExampleField($value)
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }


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
