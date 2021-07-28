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
        if('POST' === $request->getMethod()) {
            if(!empty($request->get('search')['title'])) {
                $keyword = $request->get('search')['title'];
                $instrus = $instruRepository->instrusList('', $keyword);
            } 
            if(!empty($request->get('instru'))) {
                $genre = $request->get('instru')['genre'];
                if(in_array('tous', $genre)) {
                    $instrus = $instruRepository->instrusList();
                } else {
                    $instrus = $instruRepository->instrusList($genre, '', '');
                }
            } 
            if(!empty($request->get('search')['author'])) {
                $keyword = $request->get('search')['author'];
                $instrus = $instruRepository->instrusList('', '', $keyword);
            } 
            if(!empty($request->get('instru')) && !empty($request->get('search')['title'])) {
                $keyword = $request->get('search')['title'];
                $genre = $request->get('instru')['genre'];
                if(in_array('tous', $genre)) {
                    $instrus = $instruRepository->instrusList('', $keyword, '');
                } else {
                    $instrus = $instruRepository->instrusList($genre, $keyword, '');
                }
            }
            if(!empty($request->get('instru')) && !empty($request->get('search')['author'])) {
                $keyword = $request->get('search')['author'];
                $genre = $request->get('instru')['genre'];
                if(in_array('tous', $genre)) {
                    $instrus = $instruRepository->instrusList('', '', $keyword);
                } else {
                    $instrus = $instruRepository->instrusList($genre, '', $keyword);
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
