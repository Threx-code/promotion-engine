<?php

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotions;
use App\Filters\LowestPriceFilter;
use App\Tests\ServiceTestCase;

class LowestPriceFilterTest extends ServiceTestCase
{
    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function test_lowest_price_promotions_filtering_is_applied_correctly(): void
    {
        // Given

        $enquiry = new LowestPriceEnquiry();

        $promotions = $this->promotionsDataProvider();
        $lowestPriceFilter = $this->container->get(LowestPriceFilter::class);

        // When

        $filteredEnquiry = $lowestPriceFilter->apply($enquiry, ...$promotions);

        //Then
        $this->assertSame(50, $filteredEnquiry->getDiscountedPrice(50));
        $this->assertSame(100, $filteredEnquiry->getPrice(100));
        $this->assertSame('Black Friday Half Price Sale', $filteredEnquiry->getPromotionName());

    }

    public function promotionsDataProvider(): array
    {
        $promotionOne = new Promotions();
        $promotionOne->setName('Black Friday help price sale');
        $promotionOne->setAdjustment(0.5);
        $promotionOne->setCriteria(["from" => "2022-11-25", "to" => "2022-11-28"]);
        $promotionOne->setType('date_range_multiplier');


        $promotionTwo = new Promotions();
        $promotionTwo->setName('Voucher 0U812');
        $promotionTwo->setAdjustment(100);
        $promotionTwo->setCriteria(["code" => "0U812"]);
        $promotionTwo->setType('fixed_price_voucher');


        $promotionThree = new Promotions();
        $promotionThree->setName('Buy one get one free');
        $promotionThree->setAdjustment(0.5);
        $promotionThree->setCriteria(["minimum_quantity" => 2]);
        $promotionThree->setType('even_items_multiplier');

        return [$promotionOne, $promotionTwo, $promotionThree];

    }

}