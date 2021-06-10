<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AudiosController extends AbstractController
{
    #[Route('/audios', name: 'audios')]
    public function index(): Response
    {
        return $this->render('audios/index.html.twig', [
            'controller_name' => 'AudiosController',
        ]);
    }
}
