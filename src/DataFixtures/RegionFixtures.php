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
        $region1->setTitle('Lorraine');
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
        $region8->setTitle('Centre-val-de-Loire');
        $manager->persist($region8);

        $region9 = new Region();
        $region9->setTitle('Haut-de-France');
        $manager->persist($region9);

        $region10 = new Region();
        $region10->setTitle('Ile-de-France');
        $manager->persist($region10);

        $region11 = new Region();
        $region11->setTitle('Aquitaine');
        $manager->persist($region11);

        $region12 = new Region();
        $region12->setTitle('Haute-Normandie');
        $manager->persist($region12);

        $region13 = new Region();
        $region13->setTitle('Basse-Normandie');
        $manager->persist($region13);

        $region14 = new Region();
        $region14->setTitle('Alsace');
        $manager->persist($region14);

        $region15 = new Region();
        $region15->setTitle('Nord-Pas-De-Calais');
        $manager->persist($region15);
        
        $manager->flush();

        $this->addReference('region1', $region1);
        $this->addReference('region2', $region2);
        $this->addReference('region3', $region3);
        $this->addReference('region4', $region4);
        $this->addReference('region5', $region5);
        $this->addReference('region6', $region6);
        $this->addReference('region7', $region7);
        $this->addReference('region8', $region8);
        $this->addReference('region9', $region9);
        $this->addReference('region10', $region10);
        $this->addReference('region11', $region11);
        $this->addReference('region12', $region12);
        $this->addReference('region13', $region13);
        $this->addReference('region14', $region14);
        $this->addReference('region15', $region15);
    }
}
