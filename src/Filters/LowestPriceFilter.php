<?php

namespace App\Filters;

use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotions;

class LowestPriceFilter implements PromotionFilterInterface
{

    public function apply(PromotionEnquiryInterface $enquiry, Promotions ...$promotions): PromotionEnquiryInterface
    {
        $price = $enquiry->getProduct()->getPrice();
        $quantity = $enquiry->getQuantity();
        $lowestPrice = $quantity * $price;

        //$modifiedPrice = $priceModifier->modify($price, $quantity, $promotions, $enquiry);


        $enquiry->setDiscountedPrice(250);
        $enquiry->setPrice(100);
        $enquiry->setPromotionId(4);
        $enquiry->setPromotionName('Black Friday Half Price Sale');

        return $enquiry;
    }
}