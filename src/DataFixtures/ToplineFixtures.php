<?php

namespace App\DataFixtures;

use App\Entity\Topline;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class ToplineFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $topline1 = new Topline();
        $topline1->setUser($this->getReference('user4'));
        $topline1->setInstru($this->getReference('instru1'));
        $topline1->setTitle('Topline 1');
        $topline1->setFile('topline_1.mp3');
        $manager->persist($topline1);

        $topline2 = new Topline();
        $topline2->setUser($this->getReference('user2'));
        $topline2->setInstru($this->getReference('instru5'));
        $topline2->setTitle('Topline 2');
        $topline2->setFile('topline_2.mp3');
        $manager->persist($topline2);

        $topline3 = new Topline();
        $topline3->setUser($this->getReference('user1'));
        $topline3->setInstru($this->getReference('instru4'));
        $topline3->setTitle('Topline 3');
        $topline3->setFile('topline_3.mp3');
        $manager->persist($topline3);

        $topline4 = new Topline();
        $topline4->setUser($this->getReference('user2'));
        $topline4->setInstru($this->getReference('instru3'));
        $topline4->setTitle('Topline 4');
        $topline4->setFile('topline_4.mp3');
        $manager->persist($topline4);

        $topline5 = new Topline();
        $topline5->setUser($this->getReference('user8'));
        $topline5->setInstru($this->getReference('instru7'));
        $topline5->setTitle('Topline 5');
        $topline5->setFile('topline_5.mp3');
        $manager->persist($topline5);

        $topline6 = new Topline();
        $topline6->setUser($this->getReference('user8'));
        $topline6->setInstru($this->getReference('instru10'));
        $topline6->setTitle('Topline 6');
        $topline6->setFile('topline_6.mp3');
        $manager->persist($topline6);

        $topline7 = new Topline();
        $topline7->setUser($this->getReference('user13'));
        $topline7->setInstru($this->getReference('instru11'));
        $topline7->setTitle('Topline 7');
        $topline7->setFile('topline_7.mp3');
        $manager->persist($topline7);

        $topline8 = new Topline();
        $topline8->setUser($this->getReference('user10'));
        $topline8->setInstru($this->getReference('instru9'));
        $topline8->setTitle('Topline 8');
        $topline8->setFile('topline_8.mp3');
        $manager->persist($topline8);

        $topline9 = new Topline();
        $topline9->setUser($this->getReference('user9'));
        $topline9->setInstru($this->getReference('instru7'));
        $topline9->setTitle('Topline 9');
        $topline9->setFile('topline_9.mp3');
        $manager->persist($topline9);

        $topline10 = new Topline();
        $topline10->setUser($this->getReference('user6'));
        $topline10->setInstru($this->getReference('instru5'));
        $topline10->setTitle('Topline 10');
        $topline10->setFile('topline_10.mp3');
        $manager->persist($topline10);

        $topline11 = new Topline();
        $topline11->setUser($this->getReference('user6'));
        $topline11->setInstru($this->getReference('instru2'));
        $topline11->setTitle('Topline 11');
        $topline11->setFile('topline_11.mp3');
        $manager->persist($topline11);

        $manager->flush();

        $this->addReference('topline1', $topline1);
        $this->addReference('topline2', $topline2);
        $this->addReference('topline3', $topline3);
        $this->addReference('topline4', $topline4);
        $this->addReference('topline5', $topline5);
        $this->addReference('topline6', $topline6);
        $this->addReference('topline7', $topline7);
        $this->addReference('topline8', $topline8);
        $this->addReference('topline9', $topline9);
        $this->addReference('topline10', $topline10);
        $this->addReference('topline11', $topline11);
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            InstruFixtures::class,
        ];
    }
}
