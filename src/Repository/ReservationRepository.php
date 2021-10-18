<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function getReservations($agence, $dateDebut, $dateFin): array{

        $req = $this->createQueryBuilder('resa')
            ->innerJoin('resa.destination', 'destination')
            ->innerJoin('resa.user', 'conducteur')
            ->leftJoin('resa.inscriptions', 'inscriptions');

        if(!empty($agence)){
            $req->andWhere('conducteur.agence = :agence')->setParameter('agence', $agence);
        }

        if(!empty($dateDebut) && !empty($dateFin)){
            $req->andWhere('resa.dateHeureDebut BETWEEN :dateDebut AND :dateFin')
                ->setParameter('dateDebut', $dateDebut)
                ->setParameter('dateFin', $dateFin);
        }

        return $req->getQuery()->getResult();

    }
}
