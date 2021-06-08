<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setName('Admin');
        $admin->setEmail('admin@example.fr');
        $admin->setPassword($this->passwordEncoder->encodePassword(
                $admin,
                'passAdmin'
        ));
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setActif(true);
        $admin->setValid(true);
        $admin->setTown('Rouen');
        $manager->persist($admin);

        $user = new User();
        $user->setName('User');
        $user->setEmail('user@example.fr');
        $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'passUser'
        ));
        $user->setRoles(['ROLE_USER']);
        $user->setActif(false);
        $user->setValid(false);
        $user->setTown('Marseilles');
        $manager->persist($user);

        $faker = Factory::create('fr_FR');

        for($i = 3; $i < 50; $i++) {
            $user = new User();
            $user -> setEmail($faker->email);
            $user -> setRoles(['ROLE_USER']);
            $user -> setPassword(random_bytes(10));
            $user -> setName($faker->name);
            $user -> setTown($faker->city);
            $user -> setPhone('0' . $faker->randomNumber(9, true));
            $user -> setValid(true);
            $user -> setActif(true);
    
            $manager->persist($user);
        }

        $manager->flush();

        $this->addReference('user1', $user);
        $this->addReference('user2', $admin);

        // for($i = 3; $i < 50; $i++) {
        //     $this->addReference('user' . $i, $user);
        // }
    }
}
