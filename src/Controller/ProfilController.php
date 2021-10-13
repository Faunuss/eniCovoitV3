<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil/{id}", name="user_profil")
     */
    public function profil(User $user): Response
    {
        $userApp = $this->getUser();
        if ($userApp->getEtat()==false){
            return $this->render('TwigBundle/userInactif.html.twig');
        }
        return $this->render('profil/index.html.twig', [
            'user' => $user
        ]);
    }
}
