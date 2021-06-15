<?php

namespace App\Controller;

use App\Repository\InstruRepository;
use App\Repository\TexteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JasonGrimes\Paginator;

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

    public function searchInstrus(InstruRepository $instruRepository)
    {
        $totalItems = $instruRepository->paginateCount();
        $itemsPerPage = 10;
        $currentPage = 1;
        $urlPattern = '/instrus?page=(:num)';
        $offset = 0;
        if(!empty($_GET['page'])) {
            $currentPage = $_GET['page'];
            $offset = ($currentPage - 1) * $itemsPerPage;
        }

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

        return $this->render('instrus/index.html.twig', [
            'instrus' => $instruRepository->paginateSearch($itemsPerPage, $offset, '["Trap"]'),
            'paginator' => $paginator
        ]);
    }
}
