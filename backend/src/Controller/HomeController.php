<?php

namespace App\Controller;

use App\Repository\InscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, InscriptionRepository $repo): Response
    {
        $session = $request->getSession();
        $user = null;

        if ($session->has('user_id')) {
            $user = $repo->find($session->get('user_id'));
        }

        return $this->render('home/index.html.twig', [
            'user' => $user
        ]);
    }
}
