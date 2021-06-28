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

    public function getStats(ToplineRepository $toplineRepo, UserRepository $userRepo, TexteRepository $texteRepo, InstruRepository $instruRepo): Response
    {
        // counting footer stats
            // total users
        $countUsers = $userRepo->paginateCount();
            // total posts
        $countTextes = $texteRepo->paginateCount();
        $countinstrus = $instruRepo->paginateCount();
        $countToplines = $toplineRepo->paginateCount();
        
        $countPosts = $countTextes + $countinstrus + $countToplines; 

        return $this->render('stats/stats.html.twig', [
            'total_users' => $countUsers,
            'total_posts' => $countPosts,
        ]);
    }

    public function getVisits(): Response
    {
        // count visits site
        $handle = fopen($this->getParameter('counter_directory').'/counter.txt', "r"); 
        if(!$handle){ 
            echo "could not open the file"; 
        } else { 
            $counter = ( int )fread($handle,20); 
            fclose($handle); 
            $counter++; 
            $handle = fopen($this->getParameter('counter_directory').'/counter.txt', "w" ); 
            fwrite($handle,$counter); 
            fclose($handle); 
        }

        return $this->render('stats/visits.html.twig', [
            'visits' => $counter,
        ]);
    }

    #[Route('/instrus/filter', name: 'filter_instru', methods: ['GET', 'POST'])]
    public function searchInstrus(Request $request, InstruRepository $instruRepo)
    {
        $totalItems = $instruRepo->paginateCount();
        $itemsPerPage = 10;
        $currentPage = 1;
        $urlPattern = '/instrus?page=(:num)';
        $offset = 0;
        if(!empty($_GET['page'])) {
            $currentPage = $_GET['page'];
            $offset = ($currentPage - 1) * $itemsPerPage;
        }
        $instrus = $instruRepo->paginateSearch($itemsPerPage, $offset, '["Trap"]');

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

        return $this->render('instrus/index.html.twig', [
            'instrus' => $instruRepo->paginateSearch($itemsPerPage, $offset, $filter),
            'paginator' => $paginator
        ]);

        $filter = $request->get('search');

        $jsonInstrus = [];
        $key = 0;
        foreach($instruRepo->findAll() as $instru) { 
           $jsonInstrus[$key++] = $instru->getInfos();
        }

        return new JsonResponse($jsonInstrus);
    }
}
