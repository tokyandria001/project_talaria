<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Repository\InscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

final class RegisterPageController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        EntityManagerInterface $em,
        InscriptionRepository $repo,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        if ($request->isMethod('GET')) {
            return $this->render('register/index.html.twig');
        }

        $data = $request->request->all();

        // Vérification des champs obligatoires
        $required = ['firstname', 'lastname', 'mail', 'password'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return $this->render('register/index.html.twig', [
                    'error' => "Champ manquant : $field"
                ]);
            }
        }

        // Vérifier email unique
        if ($repo->findOneBy(['mail' => $data['mail']])) {
            return $this->render('register/index.html.twig', [
                'error' => "Email déjà utilisé"
            ]);
        }

        // Convertir "a,b,c" => ["a","b","c"]
        $budget = !empty($data['budget'])
            ? array_map('trim', explode(',', $data['budget']))
            : [];

        $activity = !empty($data['activity'])
            ? array_map('trim', explode(',', $data['activity']))
            : [];

        $food = !empty($data['food'])
            ? array_map('trim', explode(',', $data['food']))
            : [];

        // Création user
        $user = new Inscription();
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setMail($data['mail']);
        $user->setPhone($data['phone'] ?? null);
        $user->setBudget($budget);
        $user->setActivity($activity);
        $user->setFood($food);

        // Hasher le mot de passe avec le PasswordHasher de Symfony
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Rôle par défaut
        $user->setRoles(['ROLE_USER']);

        $em->persist($user);
        $em->flush();

        // Rediriger vers login après inscription
        return $this->redirectToRoute('app_login');
    }
}