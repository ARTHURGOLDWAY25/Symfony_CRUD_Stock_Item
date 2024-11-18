<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UserRegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegistrationController extends AbstractController
{
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new Users();
        $form = $this->createForm(UserRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if user already exists
            $existingUser = $entityManager->getRepository(Users::class)->findOneBy(['email' => $user->getEmail()]);
            if ($existingUser) {
                $this->addFlash('error', 'User email already exists.');
                return $this->redirectToRoute('app_user_registration');
            }

            // Hash the password
            $plainPassword = $form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            // Set user role
            $roles = $form->get('roles')->getData();
            $role = $roles ?: 'ROLE_USER';  // Set default role if not selected
            $user->setRoles([$role]);

            // Persist the user to the database
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'User successfully created.');
            return $this->redirectToRoute('app_user_registration');
        }

        return $this->render('user_registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}

