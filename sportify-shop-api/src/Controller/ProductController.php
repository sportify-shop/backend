<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
            'imageSlug' => $product->getImageSlug(),
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

            if ($categoryId === 1) {
                $path = 'images/products/Chaussures.jpg';
            }

            if ($categoryId === 2) {
                $path = 'images/products/T-shirts.jpg';
            }

            if ($categoryId === 3) {
                $path = 'images/products/Shorts.jpg';
            }

            if ($categoryId === 4) {
                $path = 'images/products/Pantalons.jpg';
            }

            if ($categoryId === 5) {
                $path = 'images/products/Sweat & Pulls.jpg';
            }

            if ($categoryId === 6) {
                $path = 'images/products/Survêtements.jpg';
            }

            if ($categoryId === 7) {
                $path = 'images/products/Maillots de Bain.jpg';
            }

            if ($categoryId === 8) {
                $path = 'images/products/Polos.jpg';
            }

            if ($categoryId === 9) {
                $path = 'images/products/Chaussettes.jpg';
            }

            if ($categoryId === 10) {
                $path = 'images/products/Vestes.jpg';
            }

            if ($categoryId === 11) {
                $path = 'images/products/Débardeurs.jpg';
            }

            if ($categoryId === 12) {
                $path = 'images/products/Doudounes.jpg';
            }

            if ($categoryId === 13) {
                $path = 'images/products/Leggings et Collants.jpg';
            }

            if ($categoryId === 14) {
                $path = 'images/products/Peignoirs.jpg';
            }

            if ($categoryId === 15) {
                $path = 'images/products/Montres.jpg';
            }

            if ($categoryId === 16) {
                $path = 'images/products/Sac à Dos.jpg';
            }

            if ($categoryId === 17) {
                $path = 'images/products/Gants.jpg';
            }

            if ($categoryId === 18) {
                $path = 'images/products/Bonnets.jpg';
            }

            if ($categoryId === 19) {
                $path = 'images/products/Casquettes.jpg';
            }

            if ($categoryId === 20) {
                $path = 'images/products/Lunettes de Soleil.jpg';
            }

            if ($categoryId === 21) {
                $path = 'images/products/Bandeaux et Tour de cou.jpg';
            }

            if ($categoryId === 22) {
                $path = 'images/products/Robes.jpg';
            }

            if ($categoryId === 23) {
                $path = 'images/products/Brassières.jpg';
            }

            if ($categoryId === 24) {
                $path = 'images/products/Jupes.jpg';
            }

            $category = $categoryRepository->find($categoryId);

            
            $productRepository->save($product, $path, $category, true);

            return new Response(null, 201); // Created status code

        } catch (\Symfony\Component\Serializer\Exception\NotEncodableValueException $e) {
            // Handle the exception and return an error response
            return new Response('Invalid JSON data', 400);
        }
            
    }
}
