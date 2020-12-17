<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private $brands = ['iphone', 'samsung', 'huawei', 'oppo', 'xiaomi', 'oneplus'];

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        
        for ($i = 0; $i < 6; $i++) { 
            $product = new Product();
            $product->setBrand($this->brands[$i])
                    ->setPrice($faker->randomNumber(3, true))
                    ->setQuantity($faker->randomNumber(2, true));
            $manager->persist($product);
        }

        for ($j = 0; $j < 5; $j++) { 
            $client = new Client();
            $client->setName($faker->company())
                   ->setSiret($faker->siret())
                   ->setStreetAddress($faker->streetAddress())
                   ->setEmail($faker->safeEmail())
                   ->setPhoneNumber($faker->phoneNumber());
            $manager->persist($client);

            for ($k = 0; $k < 10; $k++) { 
                $user = new User();
                $user->setFirstName($faker->firstname())
                     ->setLastName($faker->lastname())
                     ->setEmail($faker->safeEmail())
                     ->setClient($client);
                $manager->persist($user);
            }
        }
        $manager->flush();
    }
}
