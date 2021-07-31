<?php

namespace App\DataFixtures;

use App\Entity\Instru;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class InstruFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $instru1 = new Instru();
        $instru1->setTitle('Lorem ipsum dolor sit');
        $instru1->setBpm(145);
        $instru1->setCle('Am');
        $instru1->setUser($this->getReference('user3'));
        $instru1->addGenre($this->getReference('genre4'));
        $manager->persist($instru1);

        $instru2 = new Instru();
        $instru2->setTitle('Rerum, quos');
        $instru2->setBpm(145);
        $instru2->setCle('Am');
        $instru2->setUser($this->getReference('user5'));
        $instru2->addGenre($this->getReference('genre1'));
        $manager->persist($instru2);

        $instru3 = new Instru();
        $instru3->setTitle('Ipsa illum eum');
        $instru3->setBpm(145);
        $instru3->setCle('Am');
        $instru3->setUser($this->getReference('user4'));
        $instru3->addGenre($this->getReference('genre2'));
        $manager->persist($instru3);

        $instru4 = new Instru();
        $instru4->setTitle('Esse cumque autem vel');
        $instru4->setBpm(145);
        $instru4->setCle('Am');
        $instru4->setUser($this->getReference('user6'));
        $instru4->addGenre($this->getReference('genre3'));
        $manager->persist($instru4);

        $instru5 = new Instru();
        $instru5->setTitle('Voluptatum dicta pariatur');
        $instru5->setBpm(145);
        $instru5->setCle('Am');
        $instru5->setUser($this->getReference('user5'));
        $instru5->addGenre($this->getReference('genre2'));
        $manager->persist($instru5);

        $manager->flush();

        $this->addReference('instru1', $instru1);
        $this->addReference('instru2', $instru2);
        $this->addReference('instru3', $instru3);
        $this->addReference('instru4', $instru4);
        $this->addReference('instru5', $instru5);
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            GenreFixtures::class,
        ];
    }
}
