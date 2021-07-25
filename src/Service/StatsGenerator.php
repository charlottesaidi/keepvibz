<?php

namespace App\Service;

use App\Repository\InstruRepository;
use App\Repository\TexteRepository;
use App\Repository\UserRepository;
use App\Repository\ToplineRepository;

class StatsGenerator 
{
    private $texteRepo;
    private $instruRepo;
    private $toplineRepo;
    private $userRepo;

    public function __construct(TexteRepository $texteRepo, ToplineRepository $toplineRepo, InstruRepository $instruRepo, UserRepository $userRepo) {
        $this->texteRepo = $texteRepo;
        $this->instruRepo = $instruRepo;
        $this->toplineRepo = $toplineRepo;
        $this->userRepo = $userRepo;
    }

    public function getMembersCount() {
        $countUsers = $this->userRepo->paginateCount();
        return $countUsers;
    }

    public function getTextesCount() {
        $countTextes = $this->texteRepo->paginateCount();
        return $countTextes;
    }

    public function getInstrusCount() {
        $countinstrus = $this->instruRepo->paginateCount();
        return $countinstrus;
    }

    public function getToplinesCount() {
        $countToplines = $this->toplineRepo->paginateCount();
        return $countToplines;
    }

    public function getAllPostsCount() {
            // total posts
        $countTextes = $this->texteRepo->paginateCount();
        $countinstrus = $this->instruRepo->paginateCount();
        $countToplines = $this->toplineRepo->paginateCount();
        
        $countPosts = $countTextes + $countinstrus + $countToplines;

        return $countPosts;
    }
}