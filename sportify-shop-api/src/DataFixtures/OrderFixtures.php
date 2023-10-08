<?php 

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UserRepository $userRepository, private ProductRepository $productRepository)
    {

    }

    public function load(ObjectManager $manager)
    {
        $orders = [];
        $users = $this->userRepository->findAll();

        for ($i = 0; $i < 10; $i++) {
            $order = new Order();
            $order->setUser(
                $users[mt_rand(0, count($users) - 1)]
            );
            $manager->persist($order);
            $orders[] = $order;
        }      

        $orderProducts = [];
        $products = $this->productRepository->findAll();

        for ($i = 0; $i < 20; $i++) {
            $orderProduct = new OrderProduct();
            $orderProduct->setProduct($products[mt_rand(0, count($products) - 1)])
                ->setOrder($orders[mt_rand(0, count($orders) - 1)]);
            $manager->persist($orderProduct);
            $orderProducts[] = $orderProduct;
        }

        foreach ($orders as $order) {
            $order->addOrderProduct(
                $orderProducts[mt_rand(0, count($orderProducts) - 1)]
            );
            $order->addOrderProduct(
                $orderProducts[mt_rand(0, count($orderProducts) - 1)]
            );
            $manager->persist($order);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ProductFixtures::class
        ];
    }
}