<?php

namespace App\Controller;

use App\Entity\SubCategory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/sub_category', name: 'sub_category_')]
class SubCategoryController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(SerializerInterface $serializer, ManagerRegistry $doctrine): JsonResponse
    {
        $subCategories = $doctrine->getRepository(SubCategory::class)->findAll();
        $data = [];

        foreach ($subCategories as $subCategory) {

            $data[] = [
                'id' => $subCategory->getId(),
                'name' => $subCategory->getName(),
                'created_at' => $subCategory->getCreatedAt(),
            ];
        }
        // VarDumper::dump($data);
        $json = $serializer->serialize($data, 'json');

        return new JsonResponse($json, 200, [], true);
    }

}
