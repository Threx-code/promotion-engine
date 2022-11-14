<?php

namespace App\Filters;

use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotions;
use App\Filters\Modifier\Factory\PriceModifierFactoryInterface;

class LowestPriceFilter implements PromotionFilterInterface
{

    public function __construct(private PriceModifierFactoryInterface $priceModifierFactory)
    {
    }

    public function apply(PromotionEnquiryInterface $enquiry, Promotions ...$promotions): PromotionEnquiryInterface
    {
        $price = $enquiry->getProduct()->getPrice();
        $enquiry->setPrice(100);
        $quantity = $enquiry->getQuantity();
        $lowestPrice = $quantity * $price;

        foreach($promotions as $promotion) {
            $priceModifier = $this->priceModifierFactory->create($promotion->getType());
            $modifiedPrice = $priceModifier->modify($price, $quantity, $promotion, $enquiry);

            if($modifiedPrice < $lowestPrice) {
                $enquiry->setDiscountedPrice($modifiedPrice);
                $enquiry->setPromotionId($promotion->getId());
                $enquiry->setPromotionName($promotion->getName());

                $lowestPrice = $modifiedPrice;
            }
        }
        return $enquiry;
    }
}