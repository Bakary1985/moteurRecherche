<?php

namespace App\Controller;

use App\Entity\Favoris;
use App\Entity\Produit;
use App\Entity\User;
use App\Repository\FavorisRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(
        ProduitRepository $produitRepo, 
        PaginatorInterface $paginator,
        EntityManagerInterface $em,
        Request $request
        
        ): Response
    {
        $query = $produitRepo->findAll();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );

        return $this->render('accueil/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/produit/{id}/favoris", name="favoris")
     */
    public function favois(
        Produit $produit,
        FavorisRepository $favorisRepository
        ): Response
    {
        $user = $this->getUser();
        $manager = $this->getDoctrine()->getManager();

        if(!$user){
            return $this->json([
                "code" => "403",
                "message" => "Vous n'avais pas le droit"
            ],403);
        }

        if($produit->postFavoris($user)){
   
            $favoris = $favorisRepository->findOneBy(["produit" => $produit,"user" => $user]);
            $manager->remove($favoris);
            $manager->flush();
            return $this->json(
                [
                    "code" => "200",
                    "message" => "Favoris retiré ",
                    "nombre" => $favorisRepository->count(["produit" => $produit])
                ],200
            );
        }

        $favoris = (new Favoris())
            ->setProduit($produit)
            ->setUser($user)
        ;
        $manager->persist($favoris);
        $manager->flush();

        return $this->json(
            [
            "code"=> "200", 
            "message" => "Ajouter comme favoris",
            "nombre" => $favorisRepository->count(["produit" =>$produit ])
            ],200);
    }
}
