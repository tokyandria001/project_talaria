<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Récupère l'utilisateur via le Security Context
        $user = $this->getUser();

        $mapboxToken = $this->getParameter('mapbox_token');

        return $this->render('home/index.html.twig', [
            'user' => $user,
            'mapbox_token' => $mapboxToken,
        ]);
    }
}
