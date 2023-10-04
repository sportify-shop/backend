<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private CategoryRepository $categoryRepository, private SubCategoryRepository $subCategoryRepository)
    {

    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $products = [];
        $genders = ['Homme', 'Femme', 'Unisexe'];


        for ($i=0; $i < 100; $i++) {
            $product = new Product();
            $product->setName($faker->words(1, true))
                ->setDescription($faker->words(40, true)) 
                ->setPrice($faker->randomDigitNotNull())
                ->setQuantity($faker->randomDigitNotNull())
                ->setAvailability($faker->words(1, true))
                ->setGender($genders[mt_rand(0, count($genders) - 1)])
                ->setImageSlug($faker->imageUrl($width = 640, $height = 480));
                
            $manager->persist($product);
            $products[] = $product;
            
        }

        $categories = $this->categoryRepository->findAll();
        $subCategories = $this->subCategoryRepository->findAll();
    
        foreach ($products as $product) {
            $product->setCategory(
                $categories[mt_rand(0, count($categories) - 1)]
            );
            $product->setSubCategory(
                $subCategories[mt_rand(0, count($subCategories) - 1)]
            );
            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            SubCategoryFixtures::class
        ];
    }
}