<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HyypFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/products', name: 'api_product_')]
class ProductController extends AbstractController
{
    #[Route('/index', name: 'index', methods: ['GET'])]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $products = $doctrine->getRepository(Product::class)->findAll();

        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getDescription(),
                'quantity' => $product->getQuantity(),
                'availability' => $product->getAvailability(),
                'gender' => $product->getGender(),
                'image_slug' => $product->getImageSlug(),
                'category_id' => $product->getCategoryId(),
                'sub_category_id' => $product->getSubCategoryId(),
                'created_at' => $product->getCreatedAt->getCreatedAt(),
            ];
        }

        return $this->json($data);
    }

    // #[Route('/{id}', name: 'show', methods: ['GET'])]
    // public function show(ManagerRegistry $doctrine, int $id): JsonResponse
    // {
    //     $product = $doctrine->getRepository(Product::class)->find($id);
        
    //     if (!$product) {
    //         return $this->json('No product found for id' . $id, 404);

    //     }

    //     $data = [
    //         'id' => $product->getId(),
    //         'name' => $product->getName(),
    //         'description' => $product->getDescription(),
    //     ];

    //     return $this->json($data);
    //     dd($data);
    // }

    // #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    // public function new(): JsonResponse
    // {
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/ProductController.php',
    //     ]);
    // }
}
