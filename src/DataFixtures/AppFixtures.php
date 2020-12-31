<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Product;
use App\Entity\Customer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $brands = ['iphone', 'samsung', 'huawei', 'oppo', 'xiaomi', 'oneplus'];
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

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
            $company = new Company();
            $company->setEmail($faker->safeEmail())
                   ->setPassword($this->encoder->encodePassword($company, 'pass123'))
                   ->setName($faker->company())
                   ->setSiret($faker->siret())
                   ->setStreetAddress($faker->streetAddress())
                   ->setPhoneNumber($faker->phoneNumber());
            $manager->persist($company);

            for ($k = 0; $k < 10; $k++) { 
                $user = new Customer();
                $user->setFirstname($faker->firstname())
                     ->setLastname($faker->lastname())
                     ->setEmail($faker->safeEmail())
                     ->setCompany($company);
                $manager->persist($user);
            }
        }
        $manager->flush();
    }
}
