<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category1 = new Category();
        $category1->setTitle('Collaboration');
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setTitle('Studio d\'enregistrement');
        $manager->persist($category2);

        $category3 = new Category();
        $category3->setTitle('Evènement');
        $manager->persist($category3);

        $manager->flush();

        $this->addReference('category1', $category1);
        $this->addReference('category2', $category2);
        $this->addReference('category3', $category3);
    }
}
