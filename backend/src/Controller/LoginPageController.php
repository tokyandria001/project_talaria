<?php

namespace App\Controller;

use App\Repository\InscriptionRepository;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LoginPageController extends AbstractController
{
    private string $jwtSecret = 'tldfghuyg26575fdszdcvghgf';

    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function index(Request $request, InscriptionRepository $repo): Response
    {
        if ($request->isMethod('GET')) {
            return $this->render('login/index.html.twig');
        }

        $mail = $request->request->get('mail');
        $password = $request->request->get('password');

        if (!$mail || !$password) {
            return $this->render('login/index.html.twig', [
                'error' => 'Mail et mot de passe requis'
            ]);
        }

        $user = $repo->findOneBy(['mail' => $mail]);

        if (!$user || !password_verify($password, $user->getPassword())) {
            return $this->render('login/index.html.twig', [
                'error' => 'Identifiants incorrects'
            ]);
        }

        // ✅ SESSION (on stocke UNIQUEMENT l’ID)
        $session = $request->getSession();
        $session->set('user_id', $user->getId());
        $session->set('last_activity', time());

        // (Optionnel) JWT si besoin plus tard
        $jwt = JWT::encode([
            'userId' => $user->getId(),
            'mail' => $user->getMail(),
            'iat' => time(),
            'exp' => time() + 3600
        ], $this->jwtSecret, 'HS256');

        return $this->redirectToRoute('app_dashboard');
    }
}
