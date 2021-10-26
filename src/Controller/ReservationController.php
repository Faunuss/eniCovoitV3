<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\Reservation;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservation", name="reservation_")
 */

class ReservationController extends AbstractController
{
    /**
     * @Route("/new", name="ajout")
     */
    public function addReservation(Request $req, EntityManagerInterface $em)
    {
        /**
         * @var User $user
         */

        $user = $this->getUser();
        $agence = $user->getAgence();

        $reservation = new Reservation();
        $reservation->setConducteur($user);

        $inscription = new Inscription();
        $inscription->setDateInscription(new DateTime('now'));
        $inscription->setReservation($reservation);
        $inscription->setUser($user);
        $reservation->addInscription($inscription);

        $formResa = $this->createForm('App\Form\ResaCreateFormType', $reservation);
        $formResa->handleRequest($req);





        return $this->render('reservation\newReservation.html.twig', ['formResa' => $formResa->createView(), 'agence' => $agence]);
    }


}
