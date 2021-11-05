<?php

namespace App\Controller;

use App\Entity\Vehicule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

{
    /**
     * @Route("/vehicule", name="vehicule_")
     */
    class VehiculeController extends AbstractController
    {

        /**
         * @Route("/afficher/{id}", name = "afficher")
         */
        public function afficher(Vehicule $vehicule): Response
        {
            return $this->render('vehicule/detailsVehicule.html.twig', [
                "vehicule" => $vehicule
            ]);
        }
    }
}
