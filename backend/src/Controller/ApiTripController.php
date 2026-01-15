<?php

namespace App\Controller;

use App\Repository\TripRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class ApiTripController extends AbstractController
{
    #[Route('/api/trip', name: 'app_api_trip')]
    public function getTrips(TripRepository $repo): JsonResponse
    {
        $trips = $repo->findAll();

        $data = array_map(fn($trip) => [
            'id' => $trip->getId(),
            'destination' => $trip->getDestination(),
            'dateStart' => $trip->getDateStart()?->format('Y-m-d'),
            'dateEnd' => $trip->getDateEnd()?->format('Y-m-d'),
            'budgetTotal' => $trip->getBudgetTotal(),
        ], $trips);

        return $this->json($data);
    }
}
