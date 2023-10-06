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
            'FireStorm Inferno',
            'RocketWave X1',
            'SpeedWing Pro',
            'PowerStreak 9000',
            'TurboRider X',
            'GlideFire 3000',
            'AquaRocket Pro',
            'TerraSpeed X1',
            'SkySailor 5000',
            'AeroFlash Elite',
            'NitroWave 360',
            'ZeroGravity Glide',
            'TidalForce Pro',
            'FusionRider X1',
            'SonicGlide 2000',
            'JetStream Inferno',
            'BlitzRunner X',
            'WaveMaster 3000',
            'SpeedDiver Pro',
            'ThunderJet 9000',
            'AeroBlitz X',
            'GravitySurfer 5000',
            'SolarWing Elite',
            'HydroCharge 360',
            'MegaThrust X1',
        ];

        $categories = $this->categoryRepository->findAll();


        for ($i=0; $i < 50; $i++) {
            $product = new Product();
            foreach ($products as $product) {
                $product->setName($names[$i]);
            }
                
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
                    $product->setImageSlug('images/products/Chaussures.jpg');
                }
    
                if ($product->getCategory()->getId() === 2) {
                    $product->setImageSlug('images/products/T-shirts.jpg');
                }
    
                if ($product->getCategory()->getId() === 3) {
                    $product->setImageSlug('images/products/Shorts.jpg');
                }
    
                if ($product->getCategory()->getId() === 4) {
                    $product->setImageSlug('images/products/Pantalons.jpg');
                }
    
                if ($product->getCategory()->getId() === 5) {
                    $product->setImageSlug('images/products/Sweat & Pulls.jpg');
                }
    
                if ($product->getCategory()->getId() === 6) {
                    $product->setImageSlug('images/products/Survêtements.jpg');
                }
    
                if ($product->getCategory()->getId() === 7) {
                    $product->setImageSlug('images/products/Maillots de Bain.jpg');
                }
    
                if ($product->getCategory()->getId() === 8) {
                    $product->setImageSlug('images/products/Polos.jpg');
                }
    
                if ($product->getCategory()->getId() === 9) {
                    $product->setImageSlug('images/products/Chaussettes.jpg');
                }
    
                if ($product->getCategory()->getId() === 10) {
                    $product->setImageSlug('images/products/Vestes.jpg');
                }
    
                if ($product->getCategory()->getId() === 11) {
                    $product->setImageSlug('images/products/Débardeurs.jpg');
                }
    
                if ($product->getCategory()->getId() === 12) {
                    $product->setImageSlug('images/products/Doudounes.jpg');
                }
    
                if ($product->getCategory()->getId() === 13) {
                    $product->setImageSlug('images/products/Leggings et Collants.jpg');
                }
    
                if ($product->getCategory()->getId() === 14) {
                    $product->setImageSlug('images/products/Peignoirs.jpg');
                }
    
                if ($product->getCategory()->getId() === 15) {
                    $product->setImageSlug('images/products/Montres.jpg');
                }
    
                if ($product->getCategory()->getId() === 16) {
                    $product->setImageSlug('images/products/Sac à Dos.jpg');
                }
    
                if ($product->getCategory()->getId() === 17) {
                    $product->setImageSlug('images/products/Gants.jpg');
                }
    
                if ($product->getCategory()->getId() === 18) {
                    $product->setImageSlug('images/products/Bonnets.jpg');
                }
    
                if ($product->getCategory()->getId() === 19) {
                    $product->setImageSlug('images/products/Casquettes.jpg');
                }
    
                if ($product->getCategory()->getId() === 20) {
                    $product->setImageSlug('images/products/Lunettes de Soleil.jpg');
                }
    
                if ($product->getCategory()->getId() === 21) {
                    $product->setImageSlug('images/products/Bandeaux et Tour de cou.jpg');
                }
    
                if ($product->getCategory()->getId() === 22) {
                    $product->setImageSlug('images/products/Robes.jpg');
                }
    
                if ($product->getCategory()->getId() === 23) {
                    $product->setImageSlug('images/products/Brassières.jpg');
                }
    
                if ($product->getCategory()->getId() === 24) {
                    $product->setImageSlug('images/products/Jupes.jpg');
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