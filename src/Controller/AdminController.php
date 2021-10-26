<?php

namespace App\Controller;

use App\Entity\EtatVehicule;
use App\Entity\User;
use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Repository\UserRepository;
use App\Repository\VehiculeRepository;
use App\Services\Verification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/", name="admin_")
 */
class AdminController extends AbstractController
{


    /**
     * @Route("accueil/", name="accueil")
     */

    public function accueilAdmin(): Response
    {
        //récupération de l'user connecté
        $user = $this->getUser();
        return $this->render('admin/accueil.html.twig',[
            'user'=>$user,
        ]);
    }
    /**
     * @Route("accueil/gestionUsers", name="gestionUsers")
     */
    public function gestionUsers(UserRepository $userRepository): Response
    {
        //récupération de la listes des users
        $users = $userRepository->findAll();

        return $this->render('admin/gestionUsers.html.twig', [
            'users'=>$users,
        ]);
    }
    /**
     * @Route("accueil/gestionVehicule", name="gestionVehicule")
     */
    public function gestionVehicule(VehiculeRepository $vehiculeRepository): Response
    {
        //récupération de la listes des users
        $vehicule = $vehiculeRepository->findAll();

        return $this->render('admin/gestionVehicule.html.twig', [
            'vehicules'=>$vehicule,
        ]);
    }
    /**
     * @Route("accueil/gestionVehicule/ajouterVehicule", name="ajouterVehicule")
     */
    public function ajouterVehicule(Request                $request,
                                    EntityManagerInterface $entityManager
    ): Response
    {

        $vehicule = new Vehicule();
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vehicule);
            $entityManager->flush();
            }



        $this->addFlash('success', 'Le véhicule a bien été ajouté.');
        return $this->render('admin/ajouterVehicule.html.twig',[
            'formVehicule' => $form->createView()
        ]);

    }
    /**
     * @Route("accueil/gestionUsers/modifRoles/{id}", name="modifierRole")
     */
    public function modifierRole(User $user,EntityManagerInterface $entityManager): Response
    {
        $userRoles = $user->getRoles();
        //si 2 rôles dans le tableau enlever
        if (in_array('ROLE_USER',$userRoles)) {
            $user->setRoles(["ROLE_ADMIN"]);
        }
        if (in_array('ROLE_ADMIN',$userRoles)){
            $user->setRoles(['ROLE_USER']);
        }
        $entityManager->flush();
        return $this->redirectToRoute('admin_gestionUsers');
    }
    /**
     * @Route("accueil/gestionUser/supprimer/{id}", name="supprimer_user")
     */
    public function supprimerUser(User $user,EntityManagerInterface $entityManager): Response
    {

        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('admin_gestionUsers');
    }
    /**
     * @Route("accueil/gestionVehicule/supprimer/{id}", name="supprimer_vehicule")
     */
    public function supprimerVehicule(Vehicule $vehicule,EntityManagerInterface $entityManager): Response
    {

        $entityManager->remove($vehicule);
        $entityManager->flush();
        return $this->redirectToRoute('admin_gestionVehicule');
    }
    /**
     * @Route("accueil/gestionVehicule/modifVehicule/{id}", name="modifierVehicule")
     */
    public function modifierVehicule(Vehicule $vehicule,
                                    Request                $request,
                                    EntityManagerInterface $entityManager
    ): Response
    {


        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Le véhicule a bien été modifié.');
            return $this->redirectToRoute('admin_gestionVehicule');

        }




        return $this->render('admin/modifierVehicule.html.twig',[
            'formVehicule' => $form->createView()
        ]);

    }

}
