<?php

namespace App\Filters\Modifier;

use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotions;
use JetBrains\PhpStorm\Pure;

class FixedPriceVoucher implements PriceModifierInterface
{

    #[Pure] public function modify(int $price, int $quantity, Promotions $promotion, PromotionEnquiryInterface $enquiry): int
    {
        if(!($enquiry->getVoucherCode() === $promotion->getCriteria()['code'])){
            return $price * $quantity;
        }

        return $promotion->getAdjustment() * $quantity;
    }
}