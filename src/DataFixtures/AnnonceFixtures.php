<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class AnnonceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $annonce1 = new Annonce();
        $annonce1->setUser($this->getReference('user'));
        $annonce1->setTitle('Recherche ' . ' ' . $faker->city);
        $annonce1->setDescription('Description de la recherche à ' . ' ' . $faker->city);
        $annonce1->setStatus("draft");
        $annonce1->setRegion($this->getReference('region1'));
        $annonce1->addCategory($this->getReference('category1'));

        $manager->persist($annonce1);

        $annonce2 = new Annonce();
        $annonce2->setUser($this->getReference('user'));
        $annonce2->setTitle('Recherche à ' . ' ' . $faker->city);
        $annonce2->setDescription('Recherche Beatmaker sur Grenoble');
        $annonce2->setStatus("draft");
        $annonce2->setRegion($this->getReference('region2'));
        $annonce2->addCategory($this->getReference('category1'));

        $manager->persist($annonce2);

        for($i = 1; $i < 5; $i++) {
            $annonce = new Annonce();
            $annonce->setUser($this->getReference('user'.$i));
            $annonce->setTitle('Evenement à ' . ' ' . $faker->city);
            $annonce->setDescription('Description de l\'évènement se déroulant à' . ' ' . $faker->city);
            $annonce->setStatus("published");
            $annonce->setRegion($this->getReference('region'. $i));
            $annonce->addCategory($this->getReference('category3'));
            $manager->persist($annonce);
        }

        for($i = 1; $i < 10; $i++) {
            $annonce = new Annonce();
            $annonce->setUser($this->getReference('user' . $i));
            $annonce->setTitle('Recherche à ' . ' ' . $faker->city);
            $annonce->setDescription('Description de la recherche à ' . ' ' . $faker->city);
            $annonce->setStatus("draft");
            $annonce->setRegion($this->getReference('region' . $i));
            $annonce->addCategory($this->getReference('category2'));

            $manager->persist($annonce);
        }

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
