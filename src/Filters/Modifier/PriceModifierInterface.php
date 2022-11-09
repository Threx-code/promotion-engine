<?php

namespace App\Filters\Modifier;

use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotions;

interface PriceModifierInterface
{
    public function modify(int $price, int $quantity, Promotions $promotion, PromotionEnquiryInterface $enquiry): int;
}