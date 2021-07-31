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
        $fakeRefrain = 'Eos libero voluptatibus adipisci maiores numquam architecto culpa omnis soluta perferendis cumque autem similique atque, iste sint repellendus. Ipsa, dicta laudantium! Sit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, ex. Esse cumque autem vel ex minus, qui alias magnam corporis, nulla incidunt iusto modi et ut voluptatibus temporibus quibusdam eius?';
        $fakeCouplet = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatum dicta pariatur consequuntur iure libero rem. Nemo, ab ullam, voluptates ratione sit odio amet et officiis distinctio dicta, velit ut porro. Lorem ipsum dolor sit amet consectetur adipisicing elit. Id, eum. Unde quisquam veritatis cum repellendus, omnis maxime iure magni repudiandae explicabo dolor excepturi officia alias perferendis, libero reiciendis nihil necessitatibus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo minima corrupti laborum nesciunt impedit iure, autem omnis quasi fugit iusto recusandae magnam veniam. Eum quia amet laborum itaque, doloribus earum! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Totam optio earum cum reprehenderit sapiente molestias nulla velit autem quo, suscipit inventore dolorum consequatur labore maiores reiciendis laudantium mollitia obcaecati nam! Lorem ipsum, dolor sit amet consectetur adipisicing elit. Distinctio assumenda delectus fugiat sed nemo tempore ullam nihil dicta tempora dolorum quos suscipit expedita minima maiores voluptatem animi, veniam sit voluptas!';

        $texte1 = new Texte();
        $texte1->setTitle('Voluptatum dicta pariatur');
        $texte1->setUser($this->getReference('user3'));
        $texte1->setCouplet($fakeCouplet);
        $texte1->setRefrain($fakeRefrain);
        $texte1->addInstru($this->getReference('instru1'));
        $texte1->setStatus('published');

        $manager->persist($texte1);

        for($i = 0; $i < 5; $i++) {
            $texte = new Texte();
            $texte->setTitle($i. 'Sit amet consectetur adipisicing'.$i);
            $texte->setUser($this->getReference('admin'));
            $texte->setCouplet($i. ' ' .$fakeCouplet. ' ' .$i);
            $texte->setRefrain($i. ' ' .$fakeRefrain. ' ' .$i);
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
