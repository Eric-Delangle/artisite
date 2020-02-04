<?php

namespace App\Repository;

use App\Entity\Qualifs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Qualifs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Qualifs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Qualifs[]    findAll()
 * @method Qualifs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QualifsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Qualifs::class);
    }

    // /**
    //  * @return Qualifs[] Returns an array of Qualifs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Qualifs
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
