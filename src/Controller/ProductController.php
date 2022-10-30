<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    #[Route('/products/{id}/lowest-price', name: 'lowest-price', methods: ['POST'])]

    public function lowestPrice($id): JsonResponse
    {

    }

}