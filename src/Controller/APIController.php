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
                $search = $request->get('search');
                $instrus = $instruRepository->filteredInstrusByKeyWord($search);
                if(empty($instrus)) {
                    $this->addFlash('result', 'La recherche n\'a donné aucun résultat');
                }
            } elseif(!empty($request->get('instru'))) {
                $search = $request->get('instru')['genre'];
                foreach($search as $value) {
                    $instrus = $instruRepository->filteredInstrusByGenre($value);
                }
                if(empty($instrus)) {
                    $this->addFlash('result', 'La recherche n\'a donné aucun résultat');
                }
            } elseif(!empty($request->get('instru')) && !empty($search->get('search'))) {
                $keyword = $request->get('search');
                $genre = $request->get('instru')['genre'];
                $instrus = $instruRepository->filteredInstrusByBoth($genre, $keyword);
                if(empty($instrus)) {
                    $this->addFlash('result', 'La recherche n\'a donné aucun résultat');
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
