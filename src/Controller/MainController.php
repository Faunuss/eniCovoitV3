<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route (path="/", name="")
     * @Route (path="/accueil", name="accueil")
     */

    public function accueil(): Response {

        return $this->render('main/accueil.html.twig');
    }

    /**
     * @Route("/home", name="home")
     */
    public function home(Request $request, EntityManagerInterface $em)
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $idUser = null;
        if($user){
            $idUser = $user->getId();
        }else{
            return $this->redirectToRoute('app_login');
        }

        $formSearch = $this->createForm('App\Form\ResaSearchFormType');
        $formSearch->handleRequest($request);

        $agence = null;
        $dateDebut = null;
        $dateFin = null;

        $reservations = $em->getRepository('App:Reservation')->getReservations($agence, $dateDebut, $dateFin);

        if($formSearch->isSubmitted() && $formSearch->isValid()){
            $agence = $formSearch->get('agence')->getData();
            $dateDebut = $formSearch->get('dateDebut')->getData();
            $dateFin = $formSearch->get('dateFin')->getData();
            if($dateDebut > $dateFin){
                if(!empty($dateFin)){
                    $this->addFlash('danger', 'Les dates saisies sont invalides!');
                    return $this->redirectToRoute('home');
                }
            }
            $reservations = $em->getRepository('App:Reservation')->getReservations($agence, $dateDebut, $dateFin);
        }

        return $this->render('main\home.html.twig', ['formSearch' => $formSearch->createView(), 'reservations' => $reservations]);
    }
}
