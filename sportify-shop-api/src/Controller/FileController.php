<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FileController extends AbstractController
{
    // private $projectDir;

    // public function __construct(string $projectDir)
    // {
    //     $this->projectDir = $projectDir;
    // }

    #[Route('/file/{imageName}', name: 'file', methods: ['GET'])]
    public function WorkflowImageAction($imageName): Response
    {
        $projectRoot = $this->getParameter('kernel.project_dir');
        $imageFilePath = $projectRoot.'/public/images/products/'.$imageName;
        $streamedResponse = new StreamedResponse();
        $streamedResponse->headers->set("Content-Type", 'image/jpeg');
        $streamedResponse->headers->set("Content-Length", filesize($imageFilePath));
    
        $streamedResponse->setCallback(function() use ($imageFilePath) {
            readfile($imageFilePath);
        });
        
        return $streamedResponse;
    }
}
