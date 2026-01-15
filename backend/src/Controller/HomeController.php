<?php

namespace App\Controller;

use App\Repository\PlaceRepository;
use App\Repository\TripRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PlaceRepository $placeRepository, TripRepository $tripRepository): Response
    {
        $places = $placeRepository->findAll();
        $trips = $tripRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'places' => $places,
            'trips' => $trips,
        ]);
    }

}
