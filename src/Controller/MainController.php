<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
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

        return $this->render('accueil.html.twig', ['formSearch' => $formSearch->createView()]);
    }
}
