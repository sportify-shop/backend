<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

#[Route('/product', name: 'product_')]
class ProductController extends AbstractController
{
    // INDEX PRODUCT + FILTERS
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(
        SerializerInterface $serializer,
        ProductRepository $productRepository,
        #[MapQueryParameter] ?string $name,
        #[MapQueryParameter] ?int $categoryId,
        #[MapQueryParameter] ?string $categoryName,
        #[MapQueryParameter] ?string $gender,
        #[MapQueryParameter] ?int $maxPrice,
        #[MapQueryParameter] ?string $orderBy
    ): JsonResponse {

        try {
            $products = $productRepository->findByQueryParameters($name, $categoryId, $categoryName, $gender, $maxPrice, $orderBy);
    
            $data = [];
    
            foreach ($products as $product) {
                $availability = ($product->getQuantity() !== null && $product->getQuantity() > 0);
    
                $data[] = [
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'description' => $product->getDescription(),
                    'price' => $product->getPrice(),
                    'quantity' => $product->getQuantity(),
                    'availability' => $availability,
                    'gender' => $product->getGender(),
                    'image_slug' => $product->getImageSlug(),
                    'category_id' => $product->getCategory()->getId(),
                    'created_at' => $product->getCreatedAt()->format('Y-m-d H:i:s'),
                ];
            }
    
            $json = $serializer->serialize($data, 'json');
    
            return new JsonResponse($json, 200, [], true);
        } catch (\Exception $e) {
            // Handle exceptions, log errors, or return an error response
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    // SHOW PRODUCT
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(SerializerInterface $serializer, ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $product = $doctrine->getRepository(Product::class)->find($id);
        
        if (!$product) {
            return $this->json('No product found for id' . $id, 404);

        }

        $data = [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
        ];

        $json = $serializer->serialize($data, 'json');

        return new JsonResponse($json, 200, [], true);
    }

    // NEW PRODUCT
    #[Route('', name: 'new', methods: ['POST'])]
    public function new(Request $request, ProductRepository $productRepository, CategoryRepository $categoryRepository, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {
        $productData = $request->getContent();
        
        try {
            $product = $serializer->deserialize($productData, Product::class, 'json');
            
            $errors = $validator->validate($product);
            if (count($errors) > 0) {
                
                $errorMessages = [];
                foreach ($errors as $error) {
                    $errorMessages[] = $error->getMessage();
                }
                
                return new Response($errorMessages[], 400); // Bad Request status code
            } 
            
            $jsonData = json_decode($productData, true);
            
            $categoryId = $jsonData['category'];

            $category = $categoryRepository->find($categoryId);

            
            $productRepository->save($product, $category, true);

            return new Response(null, 201); // Created status code

        } catch (\Symfony\Component\Serializer\Exception\NotEncodableValueException $e) {
            // Handle the exception and return an error response
            return new Response('Invalid JSON data', 400);
        }
            
    }
}
