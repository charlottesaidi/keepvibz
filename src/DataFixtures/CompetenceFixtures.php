<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Competence;

class CompetenceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $competence1 = new Competence();
        $competence1->setTitle('Beatmaker');
        $competence1->setActif(true);
        $manager->persist($competence1);

        $competence2 = new Competence();
        $competence2->setTitle('Topliner');
        $competence2->setActif(true);
        $manager->persist($competence2);

        $competence3 = new Competence();
        $competence3->setTitle('Parolier');
        $competence3->setActif(true);
        $manager->persist($competence3);

        $competence4 = new Competence();
        $competence4->setTitle('Chant');
        $competence4->setActif(true);
        $manager->persist($competence4);

        $manager->flush();

        $this->addReference('competence1', $competence1);
        $this->addReference('competence2', $competence2);
        $this->addReference('competence3', $competence3);
        $this->addReference('competence4', $competence4);
    }
}
