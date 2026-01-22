<?php

namespace App\Controller;

use App\Repository\InscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ForgotPasswordController extends AbstractController
{
    #[Route('/forgot-password', name: 'app_forgot_password', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        InscriptionRepository $repo,
        EntityManagerInterface $em
    ): Response {
        if ($request->isMethod('GET')) {
            return $this->render('login/forgot_password.html.twig');
        }

        $mail = $request->request->get('mail');
        $newPassword = $request->request->get('new_password');
        $confirmPassword = $request->request->get('confirm_password');

        if (!$mail || !$newPassword || !$confirmPassword) {
            return $this->render('login/forgot_password.html.twig', [
                'error' => 'Tous les champs sont obligatoires'
            ]);
        }

        if ($newPassword !== $confirmPassword) {
            return $this->render('login/forgot_password.html.twig', [
                'error' => 'Les mots de passe ne correspondent pas'
            ]);
        }

        $user = $repo->findOneBy(['mail' => $mail]);

        if (!$user) {
            return $this->render('login/forgot_password.html.twig', [
                'error' => 'Aucun compte trouvé avec ce mail'
            ]);
        }

        // hash du nouveau mot de passe
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $user->setPassword($hashedPassword);

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('app_login');
    }
}
