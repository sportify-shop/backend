<?php 
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        
        $faker = Factory::create('fr_FR');
        $categories = ['Chaussures', 'T-shirts', 'Shorts', 'Pantalons', 'Sweats & Pulls', 'Survêtements', 'Maillots de Bain', 'Polos', 'Chaussettes', 'Vestes', 'Débardeurs', 'Doudounes', 'Leggings et Collants', 'Peignoirs', 'Montres', 'Sac à Dos', 'Gants', 'Bonnets', 'Casquettes', 'Lunettes de Soleil', 'Bandeaux et Tour du cou', 'Robes', 'Brassières', 'Jupes'];

        for ($i=0; $i < 24; $i++) {
            $category = new Category();
            $category->setName($categories[$i]);
            
            $manager->persist($category);
        }

        $manager->flush();
    }
}