<?php

namespace App\Repository;

use App\Entity\EtatResa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EtatResa|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtatResa|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtatResa[]    findAll()
 * @method EtatResa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtatResaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtatResa::class);
    }

    // /**
    //  * @return EtatResa[] Returns an array of EtatResa objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EtatResa
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
