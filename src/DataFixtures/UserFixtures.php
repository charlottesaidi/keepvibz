<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setName('Admin');
        $admin->setEmail('admin@example.fr');
        $admin->setPassword($this->passwordEncoder->hashPassword(
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
        $user->setPassword($this->passwordEncoder->hashPassword(
                $user,
                'passUser'
        ));
        $user->setRoles(['ROLE_USER']);
        $user->setActif(false);
        $user->setValid(false);
        $user->setTown('Marseilles');
        $manager->persist($user);

        $faker = Factory::create('fr_FR');

        $user1 = new User();
        $user1->setEmail($faker->email);
        $user1->setRoles(['ROLE_USER']);
        $user1->setPassword(random_bytes(10));
        $user1->setName($faker->name);
        $user1->setTown($faker->city);
        //$user1->setPhoneNumber('030390399309');
        $user1->setValid(true);
        $user1->setActif(true);

        $manager->persist($user1);

        $user2  = new User();
        $user2 ->setEmail($faker->email);
        $user2 ->setRoles(['ROLE_USER']);
        $user2 ->setPassword(random_bytes(10));
        $user2 ->setName($faker->name);
        $user2 ->setTown($faker->city);
        //$user2 ->setPhoneNumber('+0' . $faker->randomNumber(9, true));
        $user2 ->setValid(true);
        $user2 ->setActif(true);

        $manager->persist($user2 );

        $user3 = new User();
        $user3->setEmail($faker->email);
        $user3->setRoles(['ROLE_USER']);
        $user3->setPassword(random_bytes(10));
        $user3->setName($faker->name);
        $user3->setTown($faker->city);
        //$user3->setPhoneNumber('+0' . $faker->randomNumber(9, true));
        $user3->setValid(true);
        $user3->setActif(true);

        $manager->persist($user3);

        $user4 = new User();
        $user4->setEmail($faker->email);
        $user4->setRoles(['ROLE_USER']);
        $user4->setPassword(random_bytes(10));
        $user4->setName($faker->name);
        $user4->setTown($faker->city);
        //$user4->setPhoneNumber('+0' . $faker->randomNumber(9, true));
        $user4->setValid(true);
        $user4->setActif(true);

        $manager->persist($user4);

        $user5 = new User();
        $user5->setEmail($faker->email);
        $user5->setRoles(['ROLE_USER']);
        $user5->setPassword(random_bytes(10));
        $user5->setName($faker->name);
        $user5->setTown($faker->city);
        //$user5->setPhoneNumber('+0' . $faker->randomNumber(9, true));
        $user5->setValid(true);
        $user5->setActif(true);

        $manager->persist($user5);

        $user6 = new User();
        $user6->setEmail($faker->email);
        $user6->setRoles(['ROLE_USER']);
        $user6->setPassword(random_bytes(10));
        $user6->setName($faker->name);
        $user6->setTown($faker->city);
        //$user6->setPhoneNumber('+0' . $faker->randomNumber(9, true));
        $user6->setValid(true);
        $user6->setActif(true);

        $manager->persist($user6);

        $user7 = new User();
        $user7->setEmail($faker->email);
        $user7->setRoles(['ROLE_USER']);
        $user7->setPassword(random_bytes(10));
        $user7->setName($faker->name);
        $user7->setTown($faker->city);
        //$user7->setPhoneNumber('+0' . $faker->randomNumber(9, true));
        $user7->setValid(true);
        $user7->setActif(true);

        $manager->persist($user7);

        $user8 = new User();
        $user8->setEmail($faker->email);
        $user8->setRoles(['ROLE_USER']);
        $user8->setPassword(random_bytes(10));
        $user8->setName($faker->name);
        $user8->setTown($faker->city);
        //$user8->setPhoneNumber('+0' . $faker->randomNumber(9, true));
        $user8->setValid(true);
        $user8->setActif(true);

        $manager->persist($user8);

        $user9 = new User();
        $user9->setEmail($faker->email);
        $user9->setRoles(['ROLE_USER']);
        $user9->setPassword(random_bytes(10));
        $user9->setName($faker->name);
        $user9->setTown($faker->city);
        //$user9->setPhoneNumber('+0' . $faker->randomNumber(9, true));
        $user9->setValid(true);
        $user9->setActif(true);

        $manager->persist($user9);

        $user10 = new User();
        $user10->setEmail($faker->email);
        $user10->setRoles(['ROLE_USER']);
        $user10->setPassword(random_bytes(10));
        $user10->setName($faker->name);
        $user10->setTown($faker->city);
        //$user10->setPhoneNumber('+0' . $faker->randomNumber(9, true));
        $user10->setValid(true);
        $user10->setActif(true);

        $manager->persist($user10);

        $user11 = new User();
        $user11->setEmail($faker->email);
        $user11->setRoles(['ROLE_USER']);
        $user11->setPassword(random_bytes(10));
        $user11->setName($faker->name);
        $user11->setTown($faker->city);
        //$user11->setPhoneNumber('+0' . $faker->randomNumber(9, true));
        $user11->setValid(true);
        $user11->setActif(true);

        $manager->persist($user11);

        $user12 = new User();
        $user12->setEmail($faker->email);
        $user12->setRoles(['ROLE_USER']);
        $user12->setPassword(random_bytes(10));
        $user12->setName($faker->name);
        $user12->setTown($faker->city);
        //$user12->setPhoneNumber('+0' . $faker->randomNumber(9, true));
        $user12->setValid(true);
        $user12->setActif(true);

        $manager->persist($user12);

        $user13 = new User();
        $user13->setEmail($faker->email);
        $user13->setRoles(['ROLE_USER']);
        $user13->setPassword(random_bytes(10));
        $user13->setName($faker->name);
        $user13->setTown($faker->city);
        //$user13->setPhoneNumber('+0' . $faker->randomNumber(9, true));
        $user13->setValid(true);
        $user13->setActif(true);

        $manager->persist($user13);

        $manager->flush();

        $this->addReference('user', $user);
        $this->addReference('admin', $admin);
        
        $this->addReference('user1', $user1);
        $this->addReference('user2', $user2);
        $this->addReference('user3', $user3);
        $this->addReference('user4', $user4);
        $this->addReference('user5', $user5);
        $this->addReference('user6', $user6);
        $this->addReference('user7', $user7);
        $this->addReference('user8', $user8);
        $this->addReference('user9', $user9);
        $this->addReference('user10', $user10);
        $this->addReference('user11', $user11);
        $this->addReference('user12', $user12);
        $this->addReference('user13', $user13);
    }

    public function getDependencies()
    {
        return [
            CompetencesFixtures::class,
        ];
    }
}
