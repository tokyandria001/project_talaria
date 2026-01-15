<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LogoutController extends AbstractController
{
    #[Route('/logout', name: 'app_logout')]
    public function logout(Request $request): Response
    {
        // Récupération de la session
        $session = $request->getSession();

        // Suppression des données de connexion
        $session->remove('user');
        $session->remove('token');

        // Optionnel : invalider toute la session
        $session->invalidate();

        return $this->redirectToRoute('app_home');
    }
}
