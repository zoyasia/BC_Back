<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private const NB_CUSTOMERS = 20;
    private const NB_EMPLOYEES = 3;

    public function __construct(private UserPasswordHasherInterface $hasher) // injection du service de hachage de mot de passe avec l'interface PasswordHasher
    {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        // DONNEES TEST ADMIN
        $adminUser = new User();
        $adminUser
        ->setEmail('rh@frimousse.com')
        ->setRoles(['ROLE_ADMIN'])
        ->setPassword($this->hasher->hashPassword($adminUser, 'admninFrimousse23'))
        ->setFirstname('Laetitia')
        ->setLastname('Guillo');

        $manager->persist($adminUser);

        // DONNEES TEST EMPLOYES
        for ($i = 0; $i < self::NB_EMPLOYEES; $i++) {
            $employeeUser = new User();
            $employeeUser
            ->setEmail($faker->email())
            ->setPassword($this->hasher->hashPassword($employeeUser, 'testEmp'))
            ->setFirstname($faker->firstName())
            ->setLastname($faker->lastName())
            ->setRoles(['ROLE_EMPLOYEE'])
            ->setBirthdate($faker->dateTimeBetween('-60 years','-18 years'));
            
            $manager->persist($employeeUser);
            }

        // DONNEES TEST CLIENTS
        for ($i = 0; $i < self::NB_CUSTOMERS; $i++) {
            $customerUser = new User();
            $customerUser
            ->setEmail($faker->email())
            ->setPassword($this->hasher->hashPassword($customerUser, 'test'))
            ->setFirstname($faker->firstName())
            ->setLastname($faker->lastName())
            ->setRoles(['ROLE_USER'])
            ->setAddress($faker->address())
            ->setZipcode($faker->randomNumber(5, true))
            ->setCity($faker->city())
            ->setBirthdate($faker->dateTimeBetween('-80 years','-18 years'));
            
            $manager->persist($customerUser);
            }





        $manager->flush();
    }
}
