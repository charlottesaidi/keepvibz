<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile')]
class UserProfileController extends AbstractController
{
    #[Route('/', name: 'user_profile', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('/profile/index.html.twig');
    }

    #[Route('/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request): Response
    {
        
        return $this->render('/profile/edit.html.twig');
    }
}
