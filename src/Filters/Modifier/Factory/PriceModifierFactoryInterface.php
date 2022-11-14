<?php

namespace App\Filters\Modifier\Factory;

use App\Filters\Modifier\PriceModifierInterface;

interface PriceModifierFactoryInterface
{
    public function create(string $modifierType): PriceModifierInterface;

}