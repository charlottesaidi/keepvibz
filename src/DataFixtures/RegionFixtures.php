<?php

namespace App\DataFixtures;

use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RegionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $region1 = new Region();
        $region1->setTitle('Normandie');
        $manager->persist($region1);

        $region2 = new Region();
        $region2->setTitle('Picardie');
        $manager->persist($region2);

        $region3 = new Region();
        $region3->setTitle('Ardennes');
        $manager->persist($region3);

        $region4 = new Region();
        $region4->setTitle('Bretagne');
        $manager->persist($region4);

        $region5 = new Region();
        $region5->setTitle('Ardeches');
        $manager->persist($region5);

        $region6 = new Region();
        $region6->setTitle('Corse');
        $manager->persist($region6);

        $region7 = new Region();
        $region7->setTitle('Auvergne-Rhône-Alpes');
        $manager->persist($region7);

        $region8 = new Region();
        $region8->setTitle('Bourgogne-Franche-Comté');
        $manager->persist($region8);

        $manager->flush();

        $this->addReference('region1', $region1);
        $this->addReference('region2', $region2);
        $this->addReference('region3', $region3);
        $this->addReference('region4', $region4);
    }
}
