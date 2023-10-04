<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/products', name: 'product_')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine): JsonResponse
    {
        $category_name = $request->query->get('category_name');
        $products = $doctrine->getRepository(Product::class)->findAll();
        print('-------------'.$category_name.'-------------');
        $data = [];

        foreach ($products as $product) {

            $availability = ($product->getQuantity() !== null && $product->getQuantity() > 0);

            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getPrice(),
                'price' => $product->getDescription(),
                'quantity' => $product->getQuantity(),
                'availability' => $availability,
                'gender' => $product->getGender(),
                'image_slug' => $product->getImageSlug(),
                'category_id' => $product->getCategory()->getId(),
                'sub_category_id' => $product->getSubCategory()->getId(),
                'created_at' => $product->getCreatedAt(),
            ];
        }
        // VarDumper::dump($data);
        $json = $serializer->serialize($data, 'json');

        return new JsonResponse($json, 200, [], true);
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
