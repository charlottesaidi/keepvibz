<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\CompetenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[Route('/profile')]
class UserProfileController extends AbstractController
{
    #[Route('/', name: 'user_profile', methods: ['GET'])]
    public function index(CompetenceRepository $competenceRepository): Response
    {   
        return $this->render('/profile/index.html.twig', [
            'competences' => $competenceRepository->findAll()
        ]);
    }

    #[Route('/edit', name: 'user_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request): Response
    {
        return dd($request);
    }
}
