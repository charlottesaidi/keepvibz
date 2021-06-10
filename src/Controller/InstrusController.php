<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InstrusController extends AbstractController
{
    #[Route('/instrus', name: 'instrus')]
    public function index(): Response
    {
        return $this->render('instrus/index.html.twig', [
            'controller_name' => 'InstrusController',
        ]);
    }
}
