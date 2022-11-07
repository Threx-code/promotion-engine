<?php

namespace App\Controller;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotions;
use App\Filters\PromotionFilterInterface;
use App\Repository\ProductRepository;
use App\Services\Serializer\DTOSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private ProductRepository $repository,
        private EntityManagerInterface $entityManager
    )
    {

    }

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

        $product = $this->repository->find($id);

        $lowestPriceEnquiry->setProduct($product);

        $promotions = $this->entityManager->getRepository(Promotions::class)->findValidForProduct(
            $product,
            date_create_immutable($lowestPriceEnquiry->getRequestDate())
        );

        $modifiedEnquiry = $promotionFilter->apply($lowestPriceEnquiry, ...$promotions);
        $responseContent = $serializer->serialize($modifiedEnquiry, 'json');
        return new Response($responseContent, 200, ['Content-Type' => 'application/json']);
    }

}