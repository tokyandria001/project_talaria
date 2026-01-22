<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Repository\InscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RegisterPageController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['GET','POST'])]
    public function index(Request $request, EntityManagerInterface $em, InscriptionRepository $repo): Response
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            $required = ['firstname', 'lastname', 'mail', 'password'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return $this->render('register/index.html.twig', ['error' => "Missing field: $field"]);
                }
            }

            if ($repo->findOneBy(['mail' => $data['mail']])) {
                return $this->render('register/index.html.twig', ['error' => "Email déjà utilisé"]);
            }

            $user = new Inscription();
            $user->setFirstname($data['firstname']);
            $user->setLastname($data['lastname']);
            $user->setMail($data['mail']);
            $user->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));
            $user->setPhone($data['phone'] ?? null);
            $user->setBudget($data['budget'] ?? []);
            $user->setActivity($data['activity'] ?? []);
            $user->setFood($data['food'] ?? []);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('register/index.html.twig');
    }
}
