<?php

namespace App\Controller;

use App\Entity\Favoris;
use App\Entity\Produit;
use App\Entity\User;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index( ProduitRepository $produitRepo): Response
    {
        return $this->render('accueil/index.html.twig', [
            'products' => $produitRepo->findAll(),
        ]);
    }

    /**
     * @Route("/produit/{id}/favoris", name="favoris")
     */
    public function favois(
        Produit $produit,
        ProduitRepository $produitRepo
        ): Response
    {
        $user = $this->getUser();
        $manager = $this->getDoctrine()->getManager();

        if(!$user){
            $this->json([
                "code" => "403",
                "message" => "Vous n'avais pas le droit"
            ],403);
        }

        if($produit->postFavoris($user)){
            $favoris = $produitRepo->findBy(["produit" => $produit,"user" => $user]);
            $manager->remove($favoris);
            $manager->flush();
        }

        $favoris = (new Favoris())
            ->setProduit($produit)
            ->setUser($user)
        ;
        $manager->remove($favoris);
        $manager->flush();
        
        return $this->json(
            [
            "code"=> "200", 
            "message" => "Ajouter comme favoris"
            ],200);
    }
}
