<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email(1, true))
                ->setAddress($faker->address(1, true))
                ->setPassword($faker->password());
            $manager->persist($user);
                
        }

        $manager->flush();
    }
}
