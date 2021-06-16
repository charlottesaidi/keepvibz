<?php

namespace App\Controller\Admin;

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

#[Route('/admin')]
class DashboardController extends AbstractController
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

    #[Route('/', name: 'admin_dashboard')]
    public function index(): Response
    {
        // counting dashboard stats
            // total users
            $countUsers = $this->userRepo->paginateCount();
            // total posts
        $countTextes = $this->texteRepo->paginateCount();
        $countinstrus = $this->instruRepo->paginateCount();
        $countToplines = $this->toplineRepo->paginateCount();

        $countPosts = $countTextes + $countinstrus + $countToplines;

        return $this->render('admin/index.html.twig', [
            'total_users' => $countUsers,
            'total_instrus' => $countinstrus,
            'total_toplines' => $countToplines,
            'total_textes' => $countTextes,
        ]);
    }
}
