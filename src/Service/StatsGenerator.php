<?php

namespace App\Service;

use App\Repository\InstruRepository;
use App\Repository\TexteRepository;
use App\Repository\UserRepository;
use App\Repository\ToplineRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class StatsGenerator 
{
    private $texteRepo;
    private $instruRepo;
    private $toplineRepo;
    private $userRepo;
    private $params;

    public function __construct(TexteRepository $texteRepo, ToplineRepository $toplineRepo, InstruRepository $instruRepo, UserRepository $userRepo, ParameterBagInterface $params) {
        $this->texteRepo = $texteRepo;
        $this->instruRepo = $instruRepo;
        $this->toplineRepo = $toplineRepo;
        $this->userRepo = $userRepo;
        $this->params = $params;
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

    public function getVisits() {
           if(!isset($_SESSION['counter'])) { // It's the first visit in this session
             $handle = fopen($this->params->get('counter_directory').'/counter.txt', "r"); 
             if(!$handle){ 
              return "Could not open the file" ;
               } 
              else { 
                $counter = ( int ) fread ($handle,20) ;
                fclose ($handle) ;
                $counter++ ; 
                $handle = fopen($this->params->get('counter_directory').'/counter.txt', "w" ) ; 
                fwrite($handle,$counter) ; 
                fclose ($handle) ;
                $_SESSION['counter'] = $counter;
                return $counter;
                }

           } else { // It's not the first time, do not update the counter but show the total hits stored in session
             $counter = $_SESSION['counter'];
             return $counter;
           }
    }
}