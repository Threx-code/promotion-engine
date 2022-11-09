<?php

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotions;
use App\Filters\Modifier\DateRangeMultiplier;
use App\Filters\Modifier\EvenItemsMultiplier;
use App\Filters\Modifier\FixedPriceVoucher;
use App\Tests\ServiceTestCase;

class PriceModifierTest extends ServiceTestCase
{

    public function test_DateRangeMultiplier_returns_a_correctly_modified_price(): void
    {
        // GIVEN
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5);
        $enquiry->setRequestDate('2022-11-27');
        $promotion = new Promotions();
        $promotion->setName('Black Friday help price sale');
        $promotion->setAdjustment(0.5);
        $promotion->setCriteria(["from" => "2022-11-25", "to" => "2022-11-28"]);
        $promotion->setType('date_range_multiplier');

        $dateRangeModifier = new DateRangeMultiplier();

        //WHEN
        $modifiedPrice = $dateRangeModifier->modify(100, 5, $promotion, $enquiry);

        // THEN
        $this->assertEquals(250, $modifiedPrice);

    }


    public function test_FixedProceVoucher_returns_a_correctly_modified_price(): void
    {
        $fixedPriceVoucher = new FixedPriceVoucher();

        $promotion = new Promotions();
        $promotion->setName('Voucher 0U812');
        $promotion->setAdjustment(100);
        $promotion->setCriteria(["code" => "0U812"]);
        $promotion->setType('fixed_price_voucher');

        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5);
        $enquiry->setVoucherCode('0U812');

        $modifiedPrice = $fixedPriceVoucher->modify(100, 5, $promotion, $enquiry);

        $this->assertEquals(500, $modifiedPrice);
    }

    public function test_EvenItemsMultiplier_returns_a_correctly_modified_price(): void
    {
        $evenItemMultiplier = new EvenItemsMultiplier();

        $promotion = new Promotions();
        $promotion->setName('Buy one get one free');
        $promotion->setAdjustment(0.5);
        $promotion->setCriteria(["minimum_quantity" => 2]);
        $promotion->setType('even_items_multiplier');

        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5);
        $enquiry->setVoucherCode('0U812');

        $modifiedPrice = $evenItemMultiplier->modify(100, 5, $promotion, $enquiry);

        $this->assertEquals(300, $modifiedPrice);
    }

}