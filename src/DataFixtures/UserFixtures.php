<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1-> setName('User1');
        $user1-> setEmail('Old School');
        $user1-> setRoles(['ROLE_USER']);
        $user1-> setPassword('ferfrfeffer');
        $user1-> setName('Glox');
        $user1-> setTown('Argenteuil');
        $user1-> setPhone('0698877665');
        $user1-> setValid('Yes');
        $user1-> setActif('No');

        $manager->persist($user1);

        $admin = new User();
        $user1-> setName('Admin');
        $admin->setEmail('admin@example.fr');
        $admin->setPassword($this->passwordEncoder->encodePassword(
                $admin,
                'passAdmin'
        ));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $user = new User();
        $user-> setName('User');
        $user->setEmail('user@example.fr');
        $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'passUser'
        ));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $manager->flush();
    }
}
