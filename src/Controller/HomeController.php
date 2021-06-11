<?php

namespace App\Controller;

use App\Repository\InstruRepository;
use App\Repository\TexteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(InstruRepository $instruRepository, TexteRepository $texteRepository): Response
    {
        $instrus = $instruRepository->findLatest();
        $textes = $texteRepository->findLatest();
        return $this->render('home/index.html.twig', [
            'instrus' => $instrus,
            'textes' => $textes
        ]);
    }
}
