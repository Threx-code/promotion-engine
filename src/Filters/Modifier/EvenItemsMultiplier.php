<?php

namespace App\Filters\Modifier;

use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotions;

class EvenItemsMultiplier implements PriceModifierInterface
{

    public function modify(int $price, int $quantity, Promotions $promotion, PromotionEnquiryInterface $enquiry): int
    {
        // TODO: Implement modify() method.
    }
}