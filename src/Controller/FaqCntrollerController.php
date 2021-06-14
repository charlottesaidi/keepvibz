<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FaqCntrollerController extends AbstractController
{
    #[Route('/faq/cntroller', name: 'faq_cntroller')]
    public function index(): Response
    {
        return $this->render('faq_cntroller/index.html.twig', [
            'controller_name' => 'FaqCntrollerController',
        ]);
    }
}
