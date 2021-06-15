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
        $instru1->setTitle('Instrumentale 1');
        $instru1->setGenre(['Trap']);
        $instru1->setBpm(145);
        $instru1->setCle('Am');
        $instru1->setFile('instru_1.mp3');
        $instru1->setUser($this->getReference('user3'));
        $manager->persist($instru1);

        $instru2 = new Instru();
        $instru2->setTitle('Instrumentale 2');
        $instru2->setGenre(['Rap']);
        $instru2->setBpm(145);
        $instru2->setCle('Am');
        $instru2->setFile('instru_2.mp3');
        $instru2->setUser($this->getReference('user5'));
        $manager->persist($instru2);

        $instru3 = new Instru();
        $instru3->setTitle('Instrumentale 3');
        $instru3->setGenre(['Trap']);
        $instru3->setBpm(145);
        $instru3->setCle('Am');
        $instru3->setFile('instru_3.mp3');
        $instru3->setUser($this->getReference('user4'));
        $manager->persist($instru3);

        $instru4 = new Instru();
        $instru4->setTitle('Instrumentale 4');
        $instru4->setGenre(['Trap']);
        $instru4->setBpm(145);
        $instru4->setCle('Am');
        $instru4->setFile('instru_4.mp3');
        $instru4->setUser($this->getReference('user6'));
        $manager->persist($instru4);

        $instru5 = new Instru();
        $instru5->setTitle('Instrumentale 5');
        $instru5->setGenre(['R\'n\'B']);
        $instru5->setBpm(145);
        $instru5->setCle('Am');
        $instru5->setFile('instru_5.mp3');
        $instru5->setUser($this->getReference('user5'));
        $manager->persist($instru5);

        $instru6 = new Instru();
        $instru6->setTitle('Instrumentale 6');
        $instru6->setGenre(['Rap']);
        $instru6->setBpm(145);
        $instru6->setCle('Am');
        $instru6->setFile('instru_6.mp3');
        $instru6->setUser($this->getReference('user4'));
        $manager->persist($instru6);

        $instru7 = new Instru();
        $instru7->setTitle('Instrumentale 7');
        $instru7->setGenre(['R\'n\'B']);
        $instru7->setBpm(145);
        $instru7->setCle('Am');
        $instru7->setFile('instru_7.mp3');
        $instru7->setUser($this->getReference('user4'));
        $manager->persist($instru7);

        $instru8 = new Instru();
        $instru8->setTitle('Instrumentale 8');
        $instru8->setGenre(['R\'n\'B']);
        $instru8->setBpm(145);
        $instru8->setCle('Am');
        $instru8->setFile('instru_8.mp3');
        $instru8->setUser($this->getReference('user3'));
        $manager->persist($instru8);

        $instru9 = new Instru();
        $instru9->setTitle('Instrumentale 9');
        $instru9->setGenre(['Pop']);
        $instru9->setBpm(145);
        $instru9->setCle('Am');
        $instru9->setFile('instru_9.mp3');
        $instru9->setUser($this->getReference('user3'));
        $manager->persist($instru9);

        $instru10 = new Instru();
        $instru10->setTitle('Instrumentale 10');
        $instru10->setGenre(['Pop']);
        $instru10->setBpm(145);
        $instru10->setCle('Am');
        $instru10->setFile('instru_10.mp3');
        $instru10->setUser($this->getReference('user7'));
        $manager->persist($instru10);

        $instru11 = new Instru();
        $instru11->setTitle('Instrumentale 11');
        $instru11->setGenre(['Trap']);
        $instru11->setBpm(145);
        $instru11->setCle('Am');
        $instru11->setFile('instru_11.mp3');
        $instru11->setUser($this->getReference('user10'));
        $manager->persist($instru11);

        $manager->flush();

        $this->addReference('instru1', $instru1);
        $this->addReference('instru2', $instru2);
        $this->addReference('instru3', $instru3);
        $this->addReference('instru4', $instru4);
        $this->addReference('instru5', $instru5);
        $this->addReference('instru6', $instru6);
        $this->addReference('instru7', $instru7);
        $this->addReference('instru8', $instru8);
        $this->addReference('instru9', $instru9);
        $this->addReference('instru10', $instru10);
        $this->addReference('instru11', $instru11);
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
