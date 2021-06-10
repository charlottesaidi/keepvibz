<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TextesController extends AbstractController
{
    #[Route('/textes', name: 'textes')]
    public function index(): Response
    {
        return $this->render('textes/index.html.twig', [
            'controller_name' => 'TextesController',
        ]);
    }
}
