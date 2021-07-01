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
    public function index(InstruRepository $instruRepo): Response
    {
        // $instrus = $instruRepo->findAll();

        // $encoders = [new JsonEncoder()];

        // $normalizers = [new ObjectNormalizer()];

        // $serializer = new Serializer($normalizers, $encoders);

        // $jsonContent = $serializer->serialize($instrus, 'json', [
        //     'circular_reference_handler' => function ($object) {
        //         return $object->getId();
        //     }
        // ]);
        
        // $jsonContent = [];
        // foreach($instrus as $instru) {
        //     $jsonContent[] = $instru->getInfos();
        // }
        // $response = new JsonResponse($jsonContent);

        // $response->headers->set('Content-Type', 'application/json');

        // return $response;
    }
}
