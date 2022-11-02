<?php

namespace App\Controller;

use App\DTO\LowestPriceEnquiry;
use App\Filters\PromotionFilterInterface;
use App\Services\Serializer\DTOSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    #[Route('/products/{id}/lowest-price', name: 'lowest-price', methods: ['POST'])]

    public function lowestPrice(
        Request $request,
        int $id,
        DTOSerializer $serializer,
        PromotionFilterInterface $promotionFilter
    ): Response
    {
        /** @var LowestPriceEnquiry $lowestPriceEnquiry */
        $lowestPriceEnquiry = $serializer->deserialize($request->getContent(), LowestPriceEnquiry::class, 'json');
        $modifiedEnquiry = $promotionFilter->apply($lowestPriceEnquiry);
        $responseContent = $serializer->serialize($modifiedEnquiry, 'json');
        return new Response($responseContent, 200);
    }

}