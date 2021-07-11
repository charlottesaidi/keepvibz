<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\InstruRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use JasonGrimes\Paginator;

#[Route('/api', name: 'api_')]
class APIController extends AbstractController
{
    #[Route('/instrus', name: 'api_instrus')]
    public function index(InstruRepository $instruRepository, Request $request): Response
    {
        $totalItems = $instruRepository->paginateCount();
        $itemsPerPage = 10;
        $currentPage = 1;
        $offset = 0;
        $instrus = [];

        if('POST' === $request->getMethod()) {
            if(!empty($request->get('search'))) {
                $keyword = $request->get('search');
                $instrus = $instruRepository->filteredInstrusByKeyWord($keyword);
            } elseif(!empty($request->get('instru'))) {
                $genre = $request->get('instru')['genre'];
                foreach($genre as $value) {
                    $instrus = $instruRepository->filteredInstrusByGenre($value);
                }
                if(in_array('tous', $genre)) {
                    $instrus = $instruRepository->instrusList();
                }
            } elseif(!empty($request->get('instru')) && !empty($search->get('search'))) {
                $keyword = $request->get('search');
                $genre = $request->get('instru')['genre'];
                foreach($genre as $value) {
                    $instrus = $instruRepository->filteredInstrusByBoth($value, $keyword);
                }
                if(in_array('tous', $genre)) {
                    $instrus = $instruRepository->filteredInstrusByKeyWord($keyword);
                }
            }
        } else {
            $instrus = $instruRepository->instrusList();
        }

        $jsonContent = [];
        foreach($instrus as $instru) {
            $jsonContent[] = $instru->getInfos();
        }

        $response = new JsonResponse($jsonContent);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
