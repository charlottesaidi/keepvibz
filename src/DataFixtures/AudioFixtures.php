<?php

namespace App\DataFixtures;

use App\Entity\Audio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AudioFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $audio1 = new Audio();
        $audio1-> setTitle('Titre audio');
        $audio1-> setType(["Rap"]);
        $audio1->setUser($this->getReference('user1'));
        $audio1-> setFile('instru1.mp3');
        $audio1-> setDescription('Prod Chill BPM 145 Key Am');


        $manager->persist($audio1);


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
