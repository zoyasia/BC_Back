<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Service;
use App\Entity\Category;
use App\Entity\Article;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private const NB_CUSTOMERS = 20;
    private const NB_EMPLOYEES = 3;
    private const NB_ARTICLES = 10;
    private const SERVICE_LIST = ["Lavage & Repassage", "Nettoyage à sec", "Soins", "Ameublement"];
    private const ARTICLE_CATEGORY_LIST = ["Haut", "Bas", "Ensemble", "Extérieur", "Ameublement"];
    private const HAUTS = ["t-shirt/polo", "chemise", "gilet", "pull"];
    private const BAS = ["pantalon", "jupe", "short"];
    private const EXTERIEUR = ["manteau", "veste", "cuir", "doudoune", "imperméable", "trench"];
    private const AMEUBLEMENT = ["rideaux", "couette", "couverture", "duvet", "oreiller", "drap"];
    private const ENSEMBLE = ["costume", "robe", "combinaison"];

    // foreach category créer un article relié à cette catégorie

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
        ->setPassword($this->hasher->hashPassword($adminUser, 'adminFrimousse23'))
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

            // DONNEES TEST PRESTATIONS PRESSING
        $services = [];
        
            foreach (self::SERVICE_LIST as $serviceName) {
                $service = new Service;
                $service
                ->setName($serviceName)
                ->setDescription($faker->paragraph(2))
                ->setPrice($faker->randomFloat(1, 2, 5));
                $manager->persist($service);
                $services[] = $service;
            }

            // DONNEES TEST CATEGORIES D'ARTICLES PRESSING
            $articleCategories = [];

            $categories = [
                "HAUTS" => self::HAUTS,
                "BAS" => self::BAS,
                "EXTERIEUR" => self::EXTERIEUR,
                "AMEUBLEMENT" => self::AMEUBLEMENT,
                "ENSEMBLE" => self::ENSEMBLE
            ];
        
            foreach ($categories as $categoryName => $categoryItems) {
                $articleCategory = new Category;
                $articleCategory->setName($categoryName);
                $manager->persist($articleCategory);
                $articleCategories[] = $articleCategory;
            
                foreach ($categoryItems as $itemName) {
                    $article = new Article;
                    $article
                    ->setName($itemName)
                    ->setDescription($faker->paragraph(2))
                    ->setCategory($articleCategory)
                    ->setPrice($faker->randomFloat(1, 2, 5))
                    ->addService($faker->randomElement($services));
                    $manager->persist($article);
                }
            }


            // // V1 (avant imbrication dans les fixtures catégories):DONNEES TEST ARTICLES
            // for ($i = 0; $i < self::NB_ARTICLES; $i++) {
            //     $article = new Article();
            //     $article
            //     ->setName($faker->word())
            //     ->setDescription($faker->paragraph(2))
            //     ->setPrice($faker->randomFloat(1, 2, 5))
            //     ->setCategory($faker->randomElement($articleCategories))
            //     ->addService($faker->randomElement($services)); // voir pour articles aussi le unique()->randomelement
                

            //     $manager->persist($article);
            //     }


        $manager->flush();
    }
}
