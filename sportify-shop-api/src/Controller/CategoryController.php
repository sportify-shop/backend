<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(SerializerInterface $serializer, ManagerRegistry $doctrine): JsonResponse
    {
        $categories = $doctrine->getRepository(Category::class)->findAll();
        $data = [];

        foreach ($categories as $category) {

            $data[] = [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'created_at' => $category->getCreatedAt(),
            ];
        }
        // VarDumper::dump($data);
        $json = $serializer->serialize($data, 'json');

        return new JsonResponse($json, 200, [], true);
    }

}
