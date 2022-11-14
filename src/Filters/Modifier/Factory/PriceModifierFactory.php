<?php

namespace App\Filters\Modifier\Factory;

use App\Filters\Modifier\PriceModifierInterface;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;

class PriceModifierFactory implements PriceModifierFactoryInterface
{
    public const PRICE_MODIFIER_NAMESPACE = "App\Filters\Modifier\\";

    /**
     * @throws ClassNotFoundException
     */
    public function create(string $modifierType): PriceModifierInterface
    {
        $modifierClassBasename = str_replace('_', '', ucwords($modifierType, '_'));
        $modifier = self::PRICE_MODIFIER_NAMESPACE . $modifierClassBasename;

        if(!class_exists($modifier)){
            throw new ClassNotFoundException($modifier);
        }

        return new $modifier();
    }
}