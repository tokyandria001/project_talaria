<?php

namespace App\Controller;

use App\Entity\Trip;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TripController extends AbstractController
{
    #[Route('/api/trip', name: 'create_trip', methods: ['POST'])]
    public function createTrip(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $trip = new Trip();
        $trip->setDestination($data['destination'] ?? '');
        $trip->setDateStart(new \DateTime($data['dateStart'] ?? 'now'));
        $trip->setDateEnd(new \DateTime($data['dateEnd'] ?? 'now'));
        $trip->setBudgetTotal($data['budget'] ?? 0);

        $em->persist($trip);
        $em->flush();

        return new JsonResponse(['message' => 'Voyage créé', 'tripId' => $trip->getId()], 201);
    }
}
