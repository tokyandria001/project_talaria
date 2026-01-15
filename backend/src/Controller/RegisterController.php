<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Repository\InscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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

        // Vérification : tous les champs obligatoires existent
        $required = ['firstname', 'lastname', 'mail', 'password'];
        foreach ($required as $field) {
            if (!isset($data[$field])) {
                return new JsonResponse(["error" => "Missing field: $field"], 400);
            }
        }

        // Vérification : email déjà utilisé ?
        if ($repo->findOneBy(['mail' => $data['mail']])) {
            return new JsonResponse(["error" => "Email déjà utilisé"], 409);
        }

        // Création du user
        $user = new Inscription();
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setMail($data['mail']);

        // Hash mot de passe
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $user->setPassword($hashedPassword);

        // Champs optionnels
        $user->setPhone($data['phone'] ?? null);
        $user->setBudget($data['budget'] ?? []);
        $user->setActivity($data['activity'] ?? []);
        $user->setFood($data['food'] ?? []);

        $em->persist($user);
        $em->flush();

        return new JsonResponse([
            "message" => "Inscription réussie",
            "userId" => $user->getId()
        ], 201);
    }
}
