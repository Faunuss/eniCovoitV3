<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\Reservation;
use App\Entity\User;
use App\Entity\Vehicule;
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

        $vehicule = new Vehicule();

        $formResa = $this->createForm('App\Form\ResaCreateFormType', $reservation);
        $formAjoutVehicule = $this->createForm('App\Form\ModalFormVehiculeType', $vehicule);

        $formResa->handleRequest($req);
        $formAjoutVehicule->handleRequest($req);

        if($formResa->isSubmitted() && $formResa->isValid()){

            $dateHeureDebut = $formResa->get('dateHeureDebut')->getData();
            $dateHeureFin = $formResa->get('dateHeureFin')->getData();
            $dureeResa = date_diff($dateHeureDebut, $dateHeureFin);
            $duree = $dureeResa->format("%d jour(s) %h heure(s) et %m minute(s)");
            $nbreJoursDuree = $dureeResa->format("%d");

            $reservation->setDuree($duree);

            if($nbreJoursDuree < "6"){
                if($formResa->get('publier')->isClicked()) {
                    $reservation->setEtatResa($em->getRepository('App:EtatResa')->findOneBy(['libelle' => 'Ouverte']));
                    $this->addFlash('success', 'La réservation est ouverte');
                }elseif($formResa->get('enregistrer')){
                    $reservation->setEtatResa($em->getRepository('App:EtatResa')->findOneBy(['libelle' => 'Enregistrée']));
                    $this->addFlash('success', 'La réservation a bien été enregistrée');
                }
            }else{
                $this->addFlash('danger', 'La réservation ne peut pas dépasser 5 jours');
            }

            $em->persist($reservation);
            $em->persist($inscription);
            $em->persist($user);
            $em->flush();

        return $this->redirectToRoute('home');

        }

        if($formAjoutVehicule->isSubmitted() && $formAjoutVehicule->isValid()){

            $parcAuto = $em->getRepository('App:Vehicule')->findAll();

            foreach ($parcAuto as $vehiculeDB){
                if($formAjoutVehicule->get('immatriculation')->getData() == $vehiculeDB->getImmatriculation()){
                    $this->addFlash('danger', 'Ce véhicule est déja enregistré');
                    return $this->redirectToRoute('reservation_new');
                }
            }

            $vehicule->setEtat($em->getRepository('App:EtatVehicule')->findOneBy(['libelle' => 'Disponible']));
            $vehicule->setType($em->getRepository('App:TypeVehicule')->findOneBy(['libelle' => 'Perso']));
            $vehicule->setAgence($agence);

            $em->persist($vehicule);
            $em->flush();
            $this->addFlash('success', 'Le véhicule a bien été enregistré');
            $vehiculeAjoute = $vehicule;

            unset($formAjoutVehicule);
            $vehicule = new Vehicule();
            $formAjoutVehicule = $this->createForm('App/Form/ModalFormVehiculeType', $vehicule);

            return $this->render('reservation\newReservation.html.twig', [
                'formResa' => $formResa->createView(),
                'formAjoutVehicule' => $formAjoutVehicule->createView(),
                'agence' => $agence,
                'vehiculeAjoute' => $vehiculeAjoute
            ]);
        }

        return $this->render('reservation\newReservation.html.twig', [
            'formResa' => $formResa->createView(),
            'formAjoutVehicule' => $formAjoutVehicule->createView(),
            'agence' => $agence
        ]);
    }


}
