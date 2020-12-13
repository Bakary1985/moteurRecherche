<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;

class MonCompteController extends AbstractController
{
    /**
     * @Route("/monCompte", name="monCompte")
     * @IsGranted("ROLE_USER")
     */
    public function index(): Response
    {
        
        $user = $this->getUser();
        
        if($user->isVerified() === false){
            return $this->render('profil/error.html.twig',[]);
        }
        
        return $this->render('profil/index.html.twig', []);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
    }
}
