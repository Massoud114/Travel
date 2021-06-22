<?php

namespace App\Repository;

use App\Entity\OffreVol;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OffreVol|null find($id, $lockMode = null, $lockVersion = null)
 * @method OffreVol|null findOneBy(array $criteria, array $orderBy = null)
 * @method OffreVol[]    findAll()
 * @method OffreVol[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreVolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OffreVol::class);
    }

    // /**
    //  * @return OffreVol[] Returns an array of OffreVol objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OffreVol
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
