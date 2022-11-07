<?php

namespace App\Filters;

use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotions;

interface PromotionFilterInterface
{
    public function apply(PromotionEnquiryInterface $enquiry, Promotions ...$promotions): PromotionEnquiryInterface;
}