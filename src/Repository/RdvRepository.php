<?php

namespace App\Repository;

use App\Entity\Rdv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Rdv|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rdv|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rdv[]    findAll()
 * @method Rdv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RdvRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Rdv::class);
    }

     /**
      * @return Rdv[] On récupère un tableau de rdv pour chaque utilisateur où la date du rdv est supérieur à la date actuelle (Rdv à venir)
      */
    public function findRdvAVenirOrderByDateDesc($dateNow, $userId)
    {
        return $this->createQueryBuilder('r')
            ->AndWhere('r.date >= :dateNow')
            ->AndWhere('r.userId = :userId')
            ->orderBy('r.date', 'DESC')
            ->setParameter('dateNow', $dateNow)
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Rdv[] On récupère un tableau de rdv pour chaque utilisateur où la date du rdv est inférieur à la date actuelle (Rdv passé)
     */
    public function findRdvPasseOrderByDateDesc($dateNow, $userId)
    {
        return $this->createQueryBuilder('r')
            ->AndWhere('r.date < :dateNow')
            ->AndWhere('r.userId = :userId')
            ->orderBy('r.date', 'Desc')
            ->setParameter('dateNow', $dateNow)
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Rdv On récupère l'id d'une tâche pour tester son existance (utilisé pour vérifier si l'id passé en get d'une tâche est valide ou non)
     */
    public function isRdvExistById($id)
    {
        return $this->createQueryBuilder('r')
            ->AndWhere('r.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

//     /**
//      * @return Rdv[] Returns an array of Rdv objects
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
    public function findOneBySomeField($value): ?Rdv
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
