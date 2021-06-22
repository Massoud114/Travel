<?php

namespace App\Repository;

use App\Entity\ReservationVol;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReservationVol|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationVol|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationVol[]    findAll()
 * @method ReservationVol[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationVolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationVol::class);
    }

    // /**
    //  * @return ReservationVol[] Returns an array of ReservationVol objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReservationVol
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
