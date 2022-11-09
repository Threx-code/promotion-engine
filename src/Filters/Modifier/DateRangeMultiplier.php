<?php

namespace App\Filters\Modifier;

use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotions;
use JetBrains\PhpStorm\Pure;

class DateRangeMultiplier implements PriceModifierInterface
{

    #[Pure] public function modify(int $price, int $quantity, Promotions $promotion, PromotionEnquiryInterface $enquiry): int
    {
        $requestDate = date_create($enquiry->getRequestDate());
        $from = date_create($promotion->getCriteria()['from']);
        $to = date_create($promotion->getCriteria()['to']);


        if(!($requestDate >= $from && $requestDate < $to)){
            return $price * $quantity;
        }

        return ($price * $quantity) * $promotion->getAdjustment();
    }
}