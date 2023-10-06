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

        for ($i=0; $i < 50; $i++) {
            $product = new Product();
            foreach ($products as $product) {
                $product->setName($names[$i]);
            }    
            $product->setDescription($faker->words(40, true)) 
                ->setPrice($faker->randomDigitNotNull())
                ->setQuantity($faker->randomDigitNotNull())
                ->setAvailability($faker->words(1, true))
                ->setGender($genders[mt_rand(0, count($genders) - 1)])
                ->setImageSlug($faker->imageUrl($width = 640, $height = 640));
                
            $manager->persist($product);
            $products[] = $product;
            
        }

        $categories = $this->categoryRepository->findAll();
    
        foreach ($products as $product) {
            $product->setCategory(
                $categories[mt_rand(0, count($categories) - 1)]
            );
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