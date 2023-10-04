<?php 
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\SubCategory;
use App\DataFixtures\CategoryFixtures;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SubCategoryFixtures extends Fixture
{


    public function load(ObjectManager $manager): void
    {
        
        $faker = Factory::create('fr_FR');

        for ($i=0; $i < 10; $i++) {
            $subCategory = new SubCategory();
            $subCategory->setName($faker->words(1, true) . ' ' . $i);
            
            $manager->persist($subCategory);
            $subCategories[] = $subCategory;
        }

        $manager->flush();
    }

}