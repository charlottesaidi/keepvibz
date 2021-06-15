<?php

namespace App\Controller;

use App\Repository\InstruRepository;
use App\Entity\Instru;
use App\Repository\TexteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use JasonGrimes\Paginator;
use JMS\Serializer\SerializerBuilder;

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

    #[Route('/instrus/filter', name: 'filter_instru', methods: ['GET', 'POST'])]
    public function searchInstrus(InstruRepository $instruRepository, Request $request)
    {
        // $totalItems = $instruRepository->paginateCount();
        // $itemsPerPage = 10;
        // $currentPage = 1;
        // $urlPattern = '/instrus?page=(:num)';
        // $offset = 0;
        // if(!empty($_GET['page'])) {
        //     $currentPage = $_GET['page'];
        //     $offset = ($currentPage - 1) * $itemsPerPage;
        // }
        // $instrus = $instruRepository->paginateSearch($itemsPerPage, $offset, '["Trap"]');
        // $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

        // $intrus = $instruRepository->findAll();
        $serializer = SerializerBuilder::create()->build();
        $jsonContent = $serializer->serialize($request, 'json');

        // return $this->render('instrus/index.html.twig', [
        //     'instrus' => $instruRepository->paginateSearch($itemsPerPage, $offset, '["Trap"]')$instruRepository->paginateSearch($itemsPerPage, $offset, '["Trap"]'),
        //     'paginator' => $paginator
        // ]);
        $instrus = [];
        foreach($instruRepository->findAll() as $instru) {
           $instrus = $instru->getPropriete();
        }

        return dd($instrus);;
    }
}
