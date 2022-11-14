<?php

namespace App\Filters\Modifier;

use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotions;

class EvenItemsMultiplier implements PriceModifierInterface
{

    public function modify(int $price, int $quantity, Promotions $promotion, PromotionEnquiryInterface $enquiry): int
    {
        if($quantity < 2){
            return $price * $quantity;
        }

        $oddCount = $quantity % 2;
        $evenCount = $quantity - $oddCount;
        return (($evenCount * $price) * $promotion->getAdjustment()) + ($oddCount * $price);
    }
}