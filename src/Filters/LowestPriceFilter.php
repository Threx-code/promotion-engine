<?php

namespace App\Filters;

use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotions;

class LowestPriceFilter implements PromotionFilterInterface
{

    public function apply(PromotionEnquiryInterface $enquiry, Promotions ...$promotions): PromotionEnquiryInterface
    {
        $enquiry->setDiscountedPrice(50);
        $enquiry->setPrice(100);
        $enquiry->setPromotionId(4);
        $enquiry->setPromotionName('Black Friday Half Price Sale');

        return $enquiry;
    }
}