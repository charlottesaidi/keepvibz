<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1-> setEmail('Old School');
        $user1-> setRoles(['Admin']);
        $user1-> setPassword('ferfrfeffer');
        $user1-> setName('Glox');
        $user1-> setTown('Argenteuil');
        $user1-> setPhone('0698877665');
        $user1-> setValid('Yes');
        $user1-> setActif('No');

        $manager->persist($user1);

        $manager->flush();
    }
}
