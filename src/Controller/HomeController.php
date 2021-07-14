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
}
