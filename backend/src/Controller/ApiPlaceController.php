<?php

namespace App\Controller;

use App\Repository\PlaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class ApiPlaceController extends AbstractController
{
    #[Route('/api/place', name: 'api_places', methods: ['GET'])]
    public function getPlaces(PlaceRepository $repo): JsonResponse
    {
        $places = $repo->findAll();

        // Normaliser les données pour JSON
        $data = array_map(fn($place) => [
            'id' => $place->getId(),
            'name' => $place->getName(),
            'description' => $place->getDescription(),
            'price' => $place->getPrice(),
            'latitude' => $place->getLatitude(),
            'longitude' => $place->getLongitude(),
            'tags' => $place->getTags(),
        ], $places);

        return $this->json($data);
    }
}
