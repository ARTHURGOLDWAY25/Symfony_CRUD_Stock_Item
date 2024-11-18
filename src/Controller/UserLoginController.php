<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UserAuthFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserLoginController extends AbstractController
{
   
    public function login(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(UserAuthFormType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $password = $form->get('password')->getData();
    
            // Find user by email
            $existingUser = $entityManager->getRepository(Users::class)->findOneBy(['email' => $email]);
    
            if ($existingUser) {
                // Validate password
                if ($passwordHasher->isPasswordValid($existingUser, $password)) {
                    $this->addFlash('success', 'You have successfully logged in.');
    
                    // Redirect to a dashboard or home route
                    return $this->redirectToRoute('app_stock_item_index');
                } else {
                    $this->addFlash('error', 'Invalid password. Please try again.');
                }
            } else {
                $this->addFlash('error', 'User with the given email does not exist.');
            }
        }
        return $this->render('user_login/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
  
}
