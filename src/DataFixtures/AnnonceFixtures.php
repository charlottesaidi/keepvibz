<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AnnonceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $annonce1 = new Annonce();
        $annonce1-> setTitle('Evenement');
        $annonce1-> setDescription('Evenement DanceFloor sur Paris ');
        $annonce1-> setStatus(true);

        $annonce2 = new Annonce();
        $annonce2-> setTitle('Recherche');
        $annonce2-> setDescription('Recherche Beatmaker sur Grenoble');
        $annonce2-> setStatus(true);

        $manager->persist($annonce1);
        $manager->persist($annonce2);


        $manager->flush();
    }
}
