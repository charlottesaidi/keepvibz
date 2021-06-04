<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AnnonceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $annonce1 = new Annonce();
        $annonce1-> setUser($this->getReference('user1'));
        $annonce1-> setTitle('Evenement');
        $annonce1-> setDescription('Evenement DanceFloor sur Paris ');
        $annonce1-> setStatus("published");
        $annonce1-> setRegion($this->getReference('region1'));

        $annonce2 = new Annonce();
        $annonce2-> setUser($this->getReference('user1'));
        $annonce2-> setTitle('Recherche');
        $annonce2-> setDescription('Recherche Beatmaker sur Grenoble');
        $annonce2-> setStatus("draft");
        $annonce2-> setRegion($this->getReference('region2'));

        $manager->persist($annonce1);
        $manager->persist($annonce2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RegionFixtures::class,
            UserFixtures::class,
        ];
    }
}
