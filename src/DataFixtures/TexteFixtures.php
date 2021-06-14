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
        $texte1->setCouplet('Couplet 1 instru1');
        $texte1->setRefrain('Refrain instru1');
        $texte1->addInstru($this->getReference('instru1'));
        $texte1->setStatus('published');

        $manager->persist($texte1);

        for($i = 0; $i < 20; $i++) {
            $texte = new Texte();
            $texte->setTitle('Texte'.$i);
            $texte->setUser($this->getReference('admin'));
            $texte->setCouplet('Couplet'.$i. 'instru'.$i);
            $texte->setRefrain('Refrain instru'.$i);
            $texte->addInstru($this->getReference('instru1'));
            $texte->setStatus('published');
            $manager->persist($texte);
        }

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
