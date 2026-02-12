<?php

namespace App\Controller;

use App\Repository\InscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class DashboardController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(InscriptionRepository $repo): Response
    {
        // On récupère l'utilisateur connecté via Symfony Security
        $user = $this->getUser();

        // $user peut être directement passé au template
        return $this->render('dashboard/index.html.twig', [
            'user' => $user
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/dashboard/update', name: 'app_dashboard_update', methods: ['POST'])]
    public function update(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        /** @var \App\Entity\Inscription $user */
        $user = $this->getUser();

        // Mettre à jour les champs depuis le formulaire
        $user->setFirstname($request->request->get('firstname'));
        $user->setLastname($request->request->get('lastname'));
        $user->setMail($request->request->get('mail'));
        $user->setPhone($request->request->get('phone'));

        $em->flush();

        return $this->redirectToRoute('app_dashboard');
    }
}