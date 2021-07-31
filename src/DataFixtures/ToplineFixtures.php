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
        $topline1->setTitle('Voluptatum dicta pariatur');
        $topline1->setFile('topline_1.mp3');
        $manager->persist($topline1);

        $topline2 = new Topline();
        $topline2->setUser($this->getReference('user2'));
        $topline2->setInstru($this->getReference('instru5'));
        $topline2->setTitle('Esse cumque autem');
        $topline2->setFile('topline_2.mp3');
        $manager->persist($topline2);

        $topline3 = new Topline();
        $topline3->setUser($this->getReference('user1'));
        $topline3->setInstru($this->getReference('instru4'));
        $topline3->setTitle('Nemo, ab ullam');
        $topline3->setFile('topline_3.mp3');
        $manager->persist($topline3);

        $topline4 = new Topline();
        $topline4->setUser($this->getReference('user2'));
        $topline4->setInstru($this->getReference('instru3'));
        $topline4->setTitle('Lorem ipsum');
        $topline4->setFile('topline_4.mp3');
        $manager->persist($topline4);

        $topline5 = new Topline();
        $topline5->setUser($this->getReference('user8'));
        $topline5->setInstru($this->getReference('instru3'));
        $topline5->setTitle('Nam, minus');
        $topline5->setFile('topline_5.mp3');
        $manager->persist($topline5);

        $manager->flush();

        $this->addReference('topline1', $topline1);
        $this->addReference('topline2', $topline2);
        $this->addReference('topline3', $topline3);
        $this->addReference('topline4', $topline4);
        $this->addReference('topline5', $topline5);
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            InstruFixtures::class,
        ];
    }
}
