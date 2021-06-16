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
    public $texteRepo;
    public $instruRepo;
    public $toplineRepo;
    public $userRepo;

    public function __construct(TexteRepository $texteRepo, ToplineRepository $toplineRepo, InstruRepository $instruRepo, UserRepository $userRepo) {
        $this->texteRepo = $texteRepo;
        $this->instruRepo = $instruRepo;
        $this->toplineRepo = $toplineRepo;
        $this->userRepo = $userRepo;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        // listing sliders accueil
        $instrus = $this->instruRepo->findLatest();
        $textes = $this->texteRepo->findLatest();

        return $this->render('home/index.html.twig', [
            'instrus' => $instrus,
            'textes' => $textes,
        ]);
    }

    public function getStats(): Response
    {
        // counting footer stats
            // total users
        $countUsers = $this->userRepo->paginateCount();
            // total posts
        $countTextes = $this->texteRepo->paginateCount();
        $countinstrus = $this->instruRepo->paginateCount();
        $countToplines = $this->toplineRepo->paginateCount();
        
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
    public function searchInstrus(Request $request)
    {
        $totalItems = $this->instruRepo->paginateCount();
        $itemsPerPage = 10;
        $currentPage = 1;
        $urlPattern = '/instrus?page=(:num)';
        $offset = 0;
        if(!empty($_GET['page'])) {
            $currentPage = $_GET['page'];
            $offset = ($currentPage - 1) * $itemsPerPage;
        }
        // $instrus = $this->instruRepo->paginateSearch($itemsPerPage, $offset, '["Trap"]');

        // $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

        // return $this->render('instrus/index.html.twig', [
        //     'instrus' => $this->instruRepo->paginateSearch($itemsPerPage, $offset, $filter),
        //     'paginator' => $paginator
        // ]);

        $filter = $request->get('search');

        $instrus = [];
        $key = 0;
        foreach($this->instruRepo->findAll() as $instru) {
            // dd($instru->getId());
           $data = [
            'id' => $instru->getId(),
            'title' => $instru->getTitle(),
            'genre' => $instru->getGenre(),
            'bpm' => $instru->getBpm(),
            'cle' => $instru->getCle(),
            'file' => $instru->getFile(),
            'image' => $instru->getImage(),
            'created_at' => $instru->getCreatedAt(),
            'modified_at' => $instru->getModifiedAt(),
            'user' => $instru->getUser(),
            'textes' => $instru->getTextes(),
            'toplines' => $instru->getToplines(),            
            ];
            $instrus[$key++] = $data;
        }
        // dd($instrus);
        return new JsonResponse($instrus);
    }
}
