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

        // ⚠️ fallback si les champs manquent
        $user->setFirstname($request->request->get('firstname', $user->getFirstname()));
        $user->setLastname($request->request->get('lastname', $user->getLastname()));
        $user->setMail($request->request->get('mail', $user->getMail()));
        $user->setPhone($request->request->get('phone', $user->getPhone()));

        // Upload photo de profil
        $file = $request->files->get('profile_picture');

        if ($file) {
            $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/profile';

            // Crée le dossier si inexistant
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Nom unique + extension correcte
            $newFilename = uniqid('profile_', true) . '.' . $file->guessExtension();

            $file->move($uploadDir, $newFilename);

            $user->setProfilePicture($newFilename);
        }
        $em->flush();

        return $this->redirectToRoute('app_dashboard');
    }

}
