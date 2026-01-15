<?php

namespace App\Controller\Api;

use App\Entity\Inscription;
use App\Repository\InscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        InscriptionRepository $repo,
        EntityManagerInterface $em
    ): JsonResponse {

        $data = json_decode($request->getContent(), true);

        $required = ['firstname', 'lastname', 'mail', 'password'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return new JsonResponse(["error" => "Missing field: $field"], 400);
            }
        }

        if ($repo->findOneBy(['mail' => $data['mail']])) {
            return new JsonResponse(["error" => "Email déjà utilisé"], 409);
        }

        $user = new Inscription();
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setMail($data['mail']);
        $user->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));

        $user->setPhone($data['phone'] ?? null);
        $user->setBudget($data['budget'] ?? []);
        $user->setActivity($data['activity'] ?? []);
        $user->setFood($data['food'] ?? []);

        $em->persist($user);
        $em->flush();

        return new JsonResponse([
            'message' => 'Inscription réussie',
            'userId' => $user->getId()
        ], 201);
    }
}
