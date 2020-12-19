<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlgoliaController extends AbstractController
{
    /**
     * @Route("/algolia", name="algolia")
     */
    public function index(): Response
    {
        return $this->render('algolia/index.html.twig', [
            'controller_name' => 'AlgoliaController',
        ]);
    }
}
