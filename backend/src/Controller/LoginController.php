<?php

namespace App\Controller;

use App\Repository\InscriptionRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class LoginController extends AbstractController
{
    private string $jwtSecret = 'tldfghuyg26575fdszdcvghgf';

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(
        Request $request,
        InscriptionRepository $repo
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['mail'], $data['password'])) {
            return new JsonResponse(['error' => 'Mail et mot de passe requis'], 400);
        }

        $user = $repo->findOneBy(['mail' => $data['mail']]);
        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], 404);
        }

        if (!password_verify($data['password'], $user->getPassword())) {
            return new JsonResponse(['error' => 'Mot de passe incorrect'], 401);
        }

        // Création du JWT
        $payload = [
            'userId' => $user->getId(),
            'mail' => $user->getMail(),
            'iat' => time(),
            'exp' => time() + 3600, // expiration 1h
        ];

        $jwt = JWT::encode($payload, $this->jwtSecret, 'HS256');

        return new JsonResponse(['token' => $jwt]);
    }
}
