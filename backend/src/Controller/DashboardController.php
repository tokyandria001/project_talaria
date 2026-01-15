<?php

namespace App\Controller;

use App\Repository\InscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(Request $request, InscriptionRepository $repo): Response
    {
        $session = $request->getSession();
        $userId = $session->get('user_id');

        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $user = $repo->find($userId);

        return $this->render('dashboard/index.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/dashboard/update', name: 'app_dashboard_update', methods: ['POST'])]
    public function update(
        Request $request,
        InscriptionRepository $repo,
        EntityManagerInterface $em
    ): Response {
        $userId = $request->getSession()->get('user_id');

        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $user = $repo->find($userId);

        $user->setFirstname($request->request->get('firstname'));
        $user->setLastname($request->request->get('lastname'));
        $user->setMail($request->request->get('mail'));
        $user->setPhone($request->request->get('phone'));

        $em->flush();

        return $this->redirectToRoute('app_dashboard');
    }
}
