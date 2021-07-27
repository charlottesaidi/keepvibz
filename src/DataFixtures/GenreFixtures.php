<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Genre;

class GenreFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $genre1 = new Genre();
        $genre1->setLabel('Trap');
        $manager->persist($genre1);

        $genre2 = new Genre();
        $genre2->setLabel('R\'n\'B');
        $manager->persist($genre2);

        $genre3 = new Genre();
        $genre3->setLabel('Pop');
        $manager->persist($genre3);

        $genre4 = new Genre();
        $genre4->setLabel('Hip-Hop');
        $manager->persist($genre4);

        $genre5 = new Genre();
        $genre5->setLabel('Autre');
        $manager->persist($genre5);

        $manager->flush();

        $this->addReference('genre1', $genre1);
        $this->addReference('genre2', $genre2);
        $this->addReference('genre3', $genre3);
        $this->addReference('genre4', $genre4);
        $this->addReference('genre5', $genre5);
    }
}
