<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private CategoryRepository $categoryRepository)
    {

    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $products = [];
        $genders = ['Homme', 'Femme', 'Unisexe'];
        $names = [
            'TurboGlide XTreme',
            'AirBounce Pro',
            'PowerPulse Elite',
            'QuantumStrike',
            'WarpSpeed X1',
            'AquaVenture 3000',
            'ZeroGravity Racer',
            'SkyRush 360',
            'ThunderStrike Pro',
            'IceStorm Blaster',
            'HyperGlide Fusion',
            'TurboCharge X',
            'AeroWings Zephyr',
            'XtremeArchery Phantom',
            'AquaRover 5000',
            'X-TremeMoto Blitz',
            'CosmicGolf Nova',
            'LavaSurf Inferno',
            'AeroBlade 9000',
            'BioTechX Racer',
            'NovaDrive Pro',
            'AeroStrike X',
            'BlazeJet 500',
            'MegaFlex Pro',
            'LunarGlide 2000',
        ];

        $categories = $this->categoryRepository->findAll();


        for ($i=0; $i < 25; $i++) {
            $product = new Product();
            $product->setName($names[$i]);
            
                
            $product->setDescription($faker->words(40, true)) 
                ->setPrice(number_format(rand(999, 9999) / 100, 2))
                ->setQuantity($faker->randomDigitNotNull())
                ->setAvailability($faker->words(1, true))
                ->setGender($genders[mt_rand(0, count($genders) - 1)])
                ;                
            $manager->persist($product);
            $products[] = $product;
            
        }

        
    
        foreach ($products as $product) {
            $product->setCategory(
                $categories[mt_rand(0, count($categories) - 1)]
            );

                if ($product->getCategory()->getId() === 1) {
                    $product->setImageSlug('Chaussures.jpg');
                }
    
                if ($product->getCategory()->getId() === 2) {
                    $product->setImageSlug('T-shirts.jpg');
                }
    
                if ($product->getCategory()->getId() === 3) {
                    $product->setImageSlug('Shorts.jpg');
                }
    
                if ($product->getCategory()->getId() === 4) {
                    $product->setImageSlug('Pantalons.jpg');
                }
    
                if ($product->getCategory()->getId() === 5) {
                    $product->setImageSlug('Sweats.jpg');
                }
    
                if ($product->getCategory()->getId() === 6) {
                    $product->setImageSlug('Survêtements.jpg');
                }
    
                if ($product->getCategory()->getId() === 7) {
                    $product->setImageSlug('Maillots.jpg');
                }
    
                if ($product->getCategory()->getId() === 8) {
                    $product->setImageSlug('Polos.jpg');
                }
    
                if ($product->getCategory()->getId() === 9) {
                    $product->setImageSlug('Chaussettes.jpg');
                }
    
                if ($product->getCategory()->getId() === 10) {
                    $product->setImageSlug('Vestes.jpg');
                }
    
                if ($product->getCategory()->getId() === 11) {
                    $product->setImageSlug('Débardeurs.jpg');
                }
    
                if ($product->getCategory()->getId() === 12) {
                    $product->setImageSlug('Doudounes.jpg');
                }
    
                if ($product->getCategory()->getId() === 13) {
                    $product->setImageSlug('Leggings.jpg');
                }
    
                if ($product->getCategory()->getId() === 14) {
                    $product->setImageSlug('Peignoirs.jpg');
                }
    
                if ($product->getCategory()->getId() === 15) {
                    $product->setImageSlug('Montres.jpg');
                }
    
                if ($product->getCategory()->getId() === 16) {
                    $product->setImageSlug('Sacs.jpg');
                }
    
                if ($product->getCategory()->getId() === 17) {
                    $product->setImageSlug('Gants.jpg');
                }
    
                if ($product->getCategory()->getId() === 18) {
                    $product->setImageSlug('Bonnets.jpg');
                }
    
                if ($product->getCategory()->getId() === 19) {
                    $product->setImageSlug('Casquettes.jpg');
                }
    
                if ($product->getCategory()->getId() === 20) {
                    $product->setImageSlug('Lunettes.jpg');
                }
    
                if ($product->getCategory()->getId() === 21) {
                    $product->setImageSlug('Bandeaux.jpg');
                }
    
                if ($product->getCategory()->getId() === 22) {
                    $product->setImageSlug('Robes.jpg');
                }
    
                if ($product->getCategory()->getId() === 23) {
                    $product->setImageSlug('Brassières.jpg');
                }
    
                if ($product->getCategory()->getId() === 24) {
                    $product->setImageSlug('Jupes.jpg');
                }
    
            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}