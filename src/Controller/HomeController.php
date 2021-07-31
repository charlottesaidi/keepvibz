<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Instru;
use App\Entity\Texte;
use App\Entity\Topline;
use App\Repository\InstruRepository;
use App\Repository\TexteRepository;
use App\Repository\UserRepository;
use App\Repository\ToplineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use JasonGrimes\Paginator;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(TexteRepository $texteRepo, InstruRepository $instruRepo): Response
    {
        // listing sliders accueil
        $instrus = $instruRepo->findLatest();
        $textes = $texteRepo->findLatest();
        $lastUpload = $instruRepo->findOneLatestUpload();

        return $this->render('home/index.html.twig', [
            'instrus' => $instrus,
            'textes' => $textes,
            'lastUpload' => $lastUpload,
        ]);
    }

    #[Route('/mention', name: 'mention')]
    public function policyIndex(): Response
    {
        return $this->render('mention/index.html.twig');
    }

    #[Route('/faq', name: 'faq')]
    public function faqIndex(): Response
    {
        return $this->render('faq/index.html.twig');
    }
}
