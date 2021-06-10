<?php

namespace App\DataFixtures;

use App\Entity\Texte;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TexteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $texte1 = new Texte();
        $texte1->setTitle('Texte 1');
        $texte1->setUser($this->getReference('user3'));
        $texte1->setCouplet(['Couplet 1 instru1']);
        $texte1->setRefrain('Refrain instru1');
        $texte1->setInstru($this->getReference('instru1'));
        $texte1->setStatus('published');
        $texte1->setContent('On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même.');

        $manager->persist($texte1);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            InstruFixtures::class,
        ];
    }
}
